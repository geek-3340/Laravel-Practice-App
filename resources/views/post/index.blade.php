<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            一覧表示
        </h2>
    </x-slot>
    
    <div class="mx-auto px-6">
        @if (session('message'))
            <div class="text-red-600 font-bold">
                {{ session('message') }}
            </div>
        @endif
        @foreach ($posts as $post)
        <div class="mt-4 p-8 bg-green-300 w-full rounded-2xl">
            <h1 class="p-4 text-lg font-semibold">
                <a href="{{route('post.show',$post)}}">
                    {{$post->title}}
                </a>
            </h1>
            <hr class="w-full">
            <p class="mt-4 p-4">
                {{$post->body}}
            </p>
            <div class="p-4 text-sm font-semibold">
                <p>
                    {{$post->created_at}} / {{$post->user->name}}
                </p>
            </div>
        </div>
        @endforeach
    </div>
    <div class="mx-auto px-6">
        <h1 class="mt-12 text-xl font-bold">条件付き表示</h1>
        @foreach ($terms as $term)
        <div class="mt-4 p-8 bg-blue-300 w-full rounded-2xl">
            <h1 class="p-4 text-lg font-semibold">
                <a href="{{route('post.show',$term)}}">
                    {{$term->title}}
                </a>
            </h1>
            <hr class="w-full">
            <p class="mt-4 p-4">
                {{$term->body}}
            </p>
            <div class="p-4 text-sm font-semibold">
                <p>
                    {{$term->created_at}} / {{$term->user->name}}
                </p>
            </div>
        </div>
        @endforeach
    </div>
</x-app-layout>
