<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\Trainer;
use App\Models\TrainerSchedule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ScheduleController extends Controller
{
    private function getTrainer(): ?Trainer
    {
        return Trainer::where('user_id', Auth::id())->first();
    }

    public function index(): View
    {
        $trainer = $this->getTrainer();

        $schedule = [];
        if ($trainer) {
            $schedule = TrainerSchedule::where('trainer_id', $trainer->id)
                ->get()
                ->keyBy('day_of_week');
        }

        $days = [
            1 => 'Понедельник',
            2 => 'Вторник',
            3 => 'Среда',
            4 => 'Четверг',
            5 => 'Пятница',
            6 => 'Суббота',
            0 => 'Воскресенье',
        ];

        return view('trainer.schedule.index', compact('trainer', 'schedule', 'days'));
    }

    public function store(Request $request): RedirectResponse
    {
        $trainer = $this->getTrainer();
        if (! $trainer) {
            return back()->with('error', 'Профиль тренера не найден');
        }

        $request->validate([
            'days' => ['nullable', 'array'],
            'days.*' => ['in:0,1,2,3,4,5,6'],
            'start_time' => ['required', 'array'],
            'start_time.*' => ['date_format:H:i'],
            'end_time' => ['required', 'array'],
            'end_time.*' => ['date_format:H:i'],
            'slot_minutes' => ['required', 'array'],
            'slot_minutes.*' => ['integer', 'in:30,45,60,90,120'],
        ]);

        $activeDays = $request->input('days', []);

        foreach ([0, 1, 2, 3, 4, 5, 6] as $day) {
            $isActive = in_array((string) $day, $activeDays);

            TrainerSchedule::updateOrCreate(
                ['trainer_id' => $trainer->id, 'day_of_week' => $day],
                [
                    'start_time' => $request->input("start_time.$day", '09:00'),
                    'end_time' => $request->input("end_time.$day", '18:00'),
                    'slot_minutes' => $request->input("slot_minutes.$day", 60),
                    'is_active' => $isActive,
                ]
            );
        }

        return back()->with('success', 'Расписание сохранено');
    }

    public function exceptions(): View
    {
        $trainer = $this->getTrainer();

        return view('trainer.schedule.exceptions', compact('trainer'));
    }

    public function storeException(Request $request): RedirectResponse
    {
        return back()->with('info', 'Функция будет доступна в следующем обновлении');
    }

    public function destroyException(string $exception): RedirectResponse
    {
        return back();
    }
}
