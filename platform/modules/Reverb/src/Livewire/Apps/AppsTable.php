<?php

namespace SokeioModule\Reverb\Livewire\Apps;

use Sokeio\Components\Table;
use Sokeio\Components\UI;
use Sokeio\Facades\Assets;
use SokeioModule\Reverb\Models\App;

class AppsTable extends Table
{
    public function mount()
    {
        //Fix:sokeio framework issue
        Assets::AddStyle('
        .field-body{
            flex:auto;
        }
        ');
    }
    protected function getTitle()
    {
        return __('Applications');
    }
    protected function getRoute()
    {
        return 'reverb.apps';
    }
    protected function getModel()
    {
        return App::class;
    }
    protected function getModalSize($isNew = true, $row = null)
    {
        return UI::MODAL_EXTRA_LARGE;
    }
    protected function getColumns()
    {
        return [
            UI::text("id")->label(__("App ID")),
            UI::text("key")->label(__("key")),
            UI::text("secret")->label(__("secret")),
            UI::textarea("options")->label(__("options")),
            UI::textarea("allowed_origins")->label(__("allowed origins")),
            UI::number("ping_interval")->label(__("ping Interval")),
            UI::number("max_message_size")->label(__("max_message_size")),
            UI::checkbox("is_active")->label(__("Is Active"))
        ];
    }
}
