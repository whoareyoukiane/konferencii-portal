<?php

class AdminController extends Controller
{
    public function index(): void
    {
        $this->requireAdmin();
        $status = $_GET['status'] ?? '';
        $eventId = (int) ($_GET['event'] ?? 0);
        $this->render('admin', [
            'requests' => (new RequestRepository())->all($status ?: null, $eventId ?: null),
            'events' => (new EventRepository())->all(),
            'status' => $status,
            'eventId' => $eventId,
        ]);
    }

    public function setStatus(int $id): void
    {
        $this->requireAdmin();
        $requests = new RequestRepository();
        $request = $requests->find($id);
        if ($request === null) {
            $this->redirect('/admin', 'Заявка не найдена');
        }
        $order = RequestRepository::STATUSES;
        $next = $order[array_search($request['status'], $order, true) + 1] ?? null;
        if ($next === null) {
            $this->redirect('/admin', 'Заявка уже завершена');
        }
        if ($next === 'завершено' && $request['event_date'] >= date('Y-m-d')) {
            $this->redirect('/admin', 'Заявку можно завершить только после даты мероприятия (' . date_ru($request['event_date']) . ')');
        }
        $requests->setStatus($id, $next);
        $this->redirect('/admin', 'Статус заявки № ' . $id . ': ' . $next);
    }

    public function delete(int $id): void
    {
        $this->requireAdmin();
        (new RequestRepository())->delete($id);
        $this->redirect('/admin', 'Заявка № ' . $id . ' удалена');
    }
}
