<?php
namespace App\Controllers;

use App\Controller;
use App\Model\Review;
use App\Model\Booking;

class ReviewController extends Controller
{
    private $reviewModel;
    private $bookingModel;

    public function __construct()
    {
        $this->reviewModel  = new Review();
        $this->bookingModel = new Booking();
    }

    // Form đánh giá
    public function create($bookingId)
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $booking = $this->bookingModel->getBookingById($bookingId);

        if (!$booking || $booking['user_id'] != $_SESSION['user_id']) {
            die('Không có quyền');
        }

        if ($booking['status'] !== 'completed') {
            die('Chưa hoàn thành');
        }

        if ($this->reviewModel->hasReviewed($bookingId)) {
            header('Location: /');
        }

        $this->render('user/review_form', ['booking' => $booking]);
    }

    // Lưu đánh giá
    public function store()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: /');
        exit;
    }

    $bookingId = (int) $_POST['booking_id'];
    $rating    = (int) $_POST['rating'];
    $comment   = trim($_POST['comment']);

    // 1. Lấy booking
    $booking = $this->bookingModel->getBookingById($bookingId);
    if (!$booking) {
        $_SESSION['flash_message'] = "Booking không tồn tại";
        header('Location: /myorders');
        exit;
    }

    // 2. Xác thực quyền (chỉ chủ booking mới được đánh giá)
    if ($booking['user_id'] != ($_SESSION['user_id'] ?? 0)) {
        $_SESSION['flash_message'] = "Bạn không có quyền đánh giá đơn này";
        header('Location: /myorders');
        exit;
    }

    // 3. Lấy room -> room_type_id
    $roomModel = new \App\Model\Room();
    $room = $roomModel->getRoomById($booking['room_id']);
    if (!$room) {
        $_SESSION['flash_message'] = "Phòng không tồn tại";
        header('Location: /myorders');
        exit;
    }
    $roomTypeId = $room['room_type_id'];

    // 4. Kiểm tra đã đánh giá chưa
    if ($this->reviewModel->hasReviewed($bookingId)) {
        $_SESSION['flash_message'] = "Bạn đã đánh giá đơn này rồi";
        header('Location: /myorders');
        exit;
    }

    // 5. Lưu review
    $this->reviewModel->create($bookingId, $roomTypeId, $rating, $comment);

    $_SESSION['flash_message'] = "Cảm ơn bạn đã đánh giá!";
    header('Location: /rooms/type/' . $roomTypeId);
    exit;
}

}
