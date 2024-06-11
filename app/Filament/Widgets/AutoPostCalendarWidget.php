<?php

namespace App\Filament\Widgets;

// use Filament\Widgets\Widget;

use App\Models\AutoPost;
use App\Models\CraigslistPost;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Filament\Actions\Action;
use Illuminate\Database\Eloquent\Builder;
class AutoPostCalendarWidget extends FullCalendarWidget
{
    public Model | string | null $model = AutoPost::class;
    /**
     * FullCalendar will call this function whenever it needs new event data.
     * This is triggered when the user clicks prev/next or switches views on the calendar.
     */

     public function config(): array
     {
         return [
            // 'firstDay' => 1,
            "editable"=> true,
             'headerToolbar' => [
                 'left' => 'dayGridDay,dayGridWeek,dayGridMonth,dayGridYear,listMonth',
                 'center' => 'title',
                 'right' => 'prev,next today',
             ],
             'droppable' => true,
         ];
     }


    public function fetchEvents(array $fetchInfo): array
    {
        // https://fullcalendar.io/docs/event-parsing
        return AutoPost::where('start_at', '>=', $fetchInfo['start'])
            ->where('start_at', '<=', $fetchInfo['end'])
            ->get()
            ->map(function (AutoPost $auto_post) {
                return [
                    'id'    => $auto_post->id,
                    'title' => 'test'.$auto_post->id,
                    'start' => $auto_post->start_at,
                    'end' => $auto_post->end_at,
                    'allDay' => 1,
                    'URL' => '/',
                    // 'plagins' ['scrollGrid']
                ];
            })
            ->toArray();
    }

    public function getFormSchema(): array
    {
        return [
            // \Filament\Forms\Components\TextInput::make('title')->readOnly(),
            // \Filament\Forms\Components\MorphToSelect::make('post_id')
            //     // ->options([
            //     //     'In Process' => $this->,
            //     //     'Reviewed' => [
            //     //         'published' => 'Published',
            //     //         'rejected' => 'Rejected',
            //     //     ],
            //     // ])
            //     // ->relationship(
            //     //     name: 'post',
            //     //     modifyQueryUsing: fn (Builder $query) => $query,
            //     // )
            //     // ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->time} {$record->post->title}")

            //     ->types([
            //         \Filament\Forms\Components\MorphToSelect\Type::make(CraigslistPost::class)
            //             ->titleAttribute('title'),

            //     ])
            //     ->native(0)
            //     ->searchable()
            //     ->preload(),

            \Filament\Forms\Components\MorphToSelect::make('post')
            ->types([
                \Filament\Forms\Components\MorphToSelect\Type::make(CraigslistPost::class)
                    ->titleAttribute('title'),
                    \Filament\Forms\Components\MorphToSelect\Type::make(User::class)
                    ->titleAttribute('id'),
            ])->searchable(),

            // \Filament\Forms\Components\Select::make('post_id')
            //     // ->options([
            //     //     'In Process' => $this->,
            //     //     'Reviewed' => [
            //     //         'published' => 'Published',
            //     //         'rejected' => 'Rejected',
            //     //     ],
            //     // ])
            //     ->relationship(
            //         name: 'post',
            //     )
            //     // ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->time} {$record->post->title}")
            //     ->native(0)
            //     ->searchable('title'),
            \Filament\Forms\Components\DatePicker::make('start_at'),
            \Filament\Forms\Components\DatePicker::make('end_at'),
            \Filament\Forms\Components\TimePicker::make('time_at'),
        ];
    }

    // https://github.com/saade/filament-fullcalendar/blob/3.x/src/Widgets/Concerns/InteractsWithEvents.php
    // public function onEventResize(array $event, array $oldEvent, array $relatedEvents, array $startDelta, array $endDelta): bool
    // {
    //     if ($this->getModel()) {
    //         $this->record = $this->resolveRecord($event['id']);
    //     }

    //     $this->mountAction('edit', [
    //         'type' => 'resize',
    //         'event' => $event,
    //         'oldEvent' => $oldEvent,
    //         'relatedEvents' => $relatedEvents,
    //         'startDelta' => $startDelta,
    //         'endDelta' => $endDelta,
    //     ]);

    //     return false;
    // }

    public function onEventClick(array $event): void
    {
        if ($this->getModel()) {
            $this->record = $this->resolveRecord($event['id']);
        }

        $this->mountAction('view', [
            'type' => 'click',
            'event' => $event,
        ]);
    }

    public function onEventDrop(array $event, array $oldEvent, array $relatedEvents, array $delta, ?array $oldResource, ?array $newResource): bool
    {
        if ($this->getModel()) {
            $this->record = $this->resolveRecord($event['id']);
        }

        $this->record->start_at = Carbon::parse($event['start']);
        $this->record->end_at = Carbon::parse($event['end']);
        $this->record->save();


        return false;
    }

    public function onEventResize(array $event, array $oldEvent, array $relatedEvents, array $startDelta, array $endDelta): bool
    {
        if ($this->getModel()) {
            $this->record = $this->resolveRecord($event['id']);
        }

        $this->record->start_at = Carbon::parse($event['start']);
        $this->record->end_at = Carbon::parse($event['end']);
        $this->record->save();

        return false;
    }

    public static function canView(): bool
    {
        return false;
    }
}
