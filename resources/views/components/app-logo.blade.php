@props(['title' => false])
<div class="flex aspect-square size-8 items-center justify-center rounded-md bg-accent-content text-accent-foreground">

<x-authentication-card-logo :title={{ $title }} />
</div>
{{-- <div class="ml-1 grid flex-1 text-left text-sm">
    <span class="mb-0.5 truncate leading-none font-semibold">Laravel Starter Kit</span>
</div> --}}
