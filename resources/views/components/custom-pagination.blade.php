@props(['displayData'])

<div class="my-6">
  {{ $displayData->onEachSide(0)->links('vendor.pagination.custom') }}
</div>