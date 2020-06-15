<?php

namespace App\Helpers;


class ViewHelper
{
    public static function controlButton($icon_code, $color, $id, $class_name)
    {
        return '<button id="'.$id.'" class="'.$class_name.' '.$icon_code.' btn '.$color.'"></button>';
    }

    public static function controlModalButton($icon_code, $color, $id, $class_name, $modal_id)
    {
        return '<button id="'.$id.'" class="'.$class_name.' '.$icon_code.' btn '.$color.'" data-toggle="modal" data-target="#'.$modal_id.'"></button>';
    }

    public static function controlLinkButton($icon_code, $color, $id, $link, $class_name, $text="")
    {
        return '<a href="'.$link.'" id="'.$id.'" class="'.$class_name.' '.$icon_code.' btn '.$color.'">'.$text.'</a>';
    }

    public static function controlLink($link, $class_name, $text="")
    {
        return '<a href="'.$link.'" class="'.$class_name.'">'.$text.'</a>';
    }
    public static function controlImage($link, $class_name,$height="",$width="")
    {
        return '<img src="'.$link.'" class="'.$class_name.'" height= "'.$height.'" width= "'.$width.'"/>';
    }
}
