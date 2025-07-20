<?php
namespace App\Enums;
enum QuestionType: string
{
    case Text = 'text'; // textarea or text input
    case Radio = 'radio'; // radio buttons
    case Checkbox = 'checkbox'; // multiple selection
    case Range = 'range'; // control from 1 to 10
    case Number = 'number'; // only positive numbers
    case Select = 'select'; // single selection drop-down menu
}
