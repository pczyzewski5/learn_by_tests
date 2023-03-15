<?php

declare(strict_types=1);

namespace App\FormType;

class QuillCommentType extends QuillType
{
    private const BLOCK_PREFIX = 'quill_comment_type';

    public function getBlockPrefix()
    {
        return self::BLOCK_PREFIX;
    }
}
