<?php

class RequestController extends Controller
{
    public function form(): void
    {
        $this->requireLogin();
        $this->render('request_new', $this->formData([], ['event_id' => (int) ($_GET['event'] ?? 0)]));
    }

    public function create(): void
    {
        $user = $this->requireLogin();
        $eventId = (int) ($_POST['event_id'] ?? 0);
        $room = $_POST['room'] ?? '';
        $payment = $_POST['payment'] ?? '';

        $errors = [];
        $event = (new EventRepository())->find($eventId);
        $requests = new RequestRepository();
        if ($event === null) {
            $errors['event_id'] = 'Выберите мероприятие';
        } elseif ($event['date'] < date('Y-m-d')) {
            $errors['event_id'] = 'Мероприятие уже прошло, заявку подать нельзя';
        } elseif ($requests->exists($user['id'], $eventId)) {
            $errors['event_id'] = 'Вы уже подали заявку на это мероприятие';
        }
        if (!in_array($room, RequestRepository::ROOMS, true)) {
            $errors['room'] = 'Выберите помещение';
        }
        if (!in_array($payment, RequestRepository::PAYMENTS, true)) {
            $errors['payment'] = 'Выберите способ оплаты';
        }

        if ($errors) {
            $old = ['event_id' => $eventId, 'room' => $room, 'payment' => $payment];
            $this->render('request_new', $this->formData($errors, $old), 422);
            return;
        }
        $requests->create($user['id'], $eventId, $room, $payment);
        $this->redirect('/requests', 'Заявка отправлена');
    }

    public function mine(): void
    {
        $user = $this->requireLogin();
        $this->render('my_requests', ['requests' => (new RequestRepository())->byUser($user['id'])]);
    }

    private function formData(array $errors, array $old): array
    {
        $events = array_filter((new EventRepository())->all(), fn($e) => $e['date'] >= date('Y-m-d'));
        return ['errors' => $errors, 'old' => $old, 'events' => $events];
    }
}
