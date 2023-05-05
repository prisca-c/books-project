<?php

namespace App\Controllers;

use App\Models\Rating;
use Core\Auth;
use Core\Controller;
use MongoDB\BSON\ObjectId;
use MongoDB\Model\BSONDocument;

class RatingsController extends Controller
{
    private Rating $ratings;

    public function __construct()
    {
        parent::__construct();
        $this->ratings = new Rating();
    }

    public function index(): array
    {
        return $this->ratings->findAll();
    }

    public function show(string $id): BSONDocument
    {
        return $this->ratings->findById($id);
    }

    public function store(array $data): array
    {
        $data = $data['data'];
        $rating = $data['rating'];
        $review = $data['review'];
        $book = $data['book'];
        $token = $_COOKIE['cookie-session'];

        $userId = Auth::decodeToken($token)['id'];

        if (empty($rating) || empty($review) || empty($book)) {
            return $this->response->internalServerError('Missing data');
        }

        if (count($data) > 4) {
            return $this->response->internalServerError('Too many data');
        }

        $rating = $this->ratings->create($data);

        //update reviews.rating to push new rating
        $this->db->__get('books')->updateOne(
            ['_id' => new ObjectId($book['_id']['$oid'])],
            ['$push' => ['reviews.ratings' => $rating->getInsertedId()]]
        );

        $this->db->__get('users')->updateOne(
            ['_id' => new ObjectId($userId)],
            ['$push' => ['reviews.ratings' => $rating->getInsertedId()]]
        );

        // get rating average from a book in ratings collection
        $ratingAvg = $this->db->ratings->aggregate([
            ['$match' => ['book' => $book]],
            ['$group' => ['_id' => '$book', 'average' => ['$avg' => '$rating']]]
        ])->toArray()[0];

        // update book.rating
        $this->db->__get('books')->updateOne(
            ['_id' => new ObjectId($book['_id']['$oid'])],
            ['$set' => ['reviews.rating' => round($ratingAvg->average,1)]]
        );

        return $this->response->created();
    }

    public function update(array $data): array
    {
        $data = $data['data'];
        $id = $data['_id'];
        $rating = $data['rating'];
        $review = $data['review'];
        $book = $data['book'];
        $user = $data['user'];

        if (empty($rating) || empty($review) || empty($book) || empty($user)) {
            return $this->response->internalServerError('Missing data');
        }

        if (count($data) > 5) {
            return $this->response->internalServerError('Too many data');
        }

        $ratingAvg = $this->db->ratings->aggregate([
            ['$match' => ['book' => new ObjectId($book['_id']['$oid'])]],
            ['$group' => ['_id' => '$book', 'average' => ['$avg' => '$rating']]]
        ]);

        $this->db->books->updateOne(
            ['_id' => new ObjectId($book['_id']['$oid'])],
            ['$set' => ['rating' => $ratingAvg->toArray()[0]->average]]
        );

        return $this->ratings->update($data);
    }

    public function delete(string $id): array
    {
        $this->db->books->updateOne(
            ['reviews.ratings' => new ObjectId($id)],
            ['$pull' => ['reviews.ratings' => new ObjectId($id)]]
        );

        $this->db->users->updateOne(
            ['reviews.ratings' => new ObjectId($id)],
            ['$pull' => ['reviews.ratings' => new ObjectId($id)]]
        );
        
        return $this->ratings->deleteById($id);
    }
}
