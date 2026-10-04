<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('livewire:clear-tmp')->daily();
