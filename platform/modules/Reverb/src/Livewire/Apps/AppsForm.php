<?php

namespace SokeioModule\Reverb\Livewire\Apps;

use Sokeio\Components\Form;
use Sokeio\Components\UI;
use Sokeio\Breadcrumb;
use SokeioModule\Reverb\Models\App;


class AppsForm extends Form
{
    public function getTitle()
    {
        return __('Applications');
    }
    public function getBreadcrumb()
    {
        return [
            Breadcrumb::Item(__('Home'), route('admin.dashboard'))
        ];
    }
    public function getButtons()
    {
        return [];
    }
    public function getModel()
    {
        return App::class;
    }
    public function generateKey()
    {
        $this->data->key = bin2hex(random_bytes(16));
    }
    public function generateSecret()
    {
        $this->data->secret = bin2hex(random_bytes(16));
    }
    public function formUI()
    {
        return UI::container([
            UI::prex(
                'data',
                [
                    UI::row([
                        UI::text("key")->label(__("key"))->afterUI([
                            UI::button("Generate Key")->wireClick("generateKey")->small(),
                        ])->col6(),
                        UI::text("secret")->label(__("secret"))->afterUI([
                            UI::button("Generate Secret")->wireClick("generateSecret")->small(),
                        ])->col6(),
                        UI::textarea("options")->label(__("options"))->col12()->valueDefault('[]'),
                        UI::textarea("allowed_origins")->label(__("allowed_origins"))->valueDefault('["*"]')->col12(),
                        UI::number("ping_interval")->label(__("ping_interval"))->col6()->valueDefault(30),
                        UI::number("max_message_size")->label(__("max_message_size"))->col6()->valueDefault(2048),
                        UI::toggle("is_active")->label(__("Active"))->col6()->valueDefault(true),
                    ])
                ]
            ),
        ])

            ->className('p-3');
    }
}
