<?php

namespace HighLiuk\Sync\Interfaces;

/**
 * @extends ReadableSource<ID,TModel,TContents>
 * @extends WritableSource<ID,TModel,TContents>
 * @template ID of string|int
 * @template TModel of SyncModel<ID>
 * @template TContents
 */
interface SyncSource extends ReadableSource, WritableSource
{
}
