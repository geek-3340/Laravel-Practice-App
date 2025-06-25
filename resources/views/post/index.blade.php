<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            一覧表示
        </h2>
    </x-slot>
    
    <div class="mx-auto px-6">
        {{-- postsテーブルの各データごとにforeachで処理を回す --}}
        @foreach ($posts as $post)
        <div class="mt-4 p-8 bg-white w-full rounded-2xl">
            <h1 class="p-4 text-lg font-semibold">
                {{-- titleを取得し表示 --}}
                {{$post->title}}
            </h1>
            <hr class="w-full">
            <p class="mt-4 p-4">
                {{-- bodyを取得し表示 --}}
                {{$post->body}}
            </p>
            <div class="p-4 text-sm font-semibold">
                <p>
                    {{--以下の処理
                        1.Postモデルを介して投稿した日時(created_atカラムの値)を取得
                        2.Postモデルのuserメソッドでリレーションしたuserモデル参照し
                        3.EloquentORMでuser_idに一致する主キーのユーザー名を取得
                        4.取得した値を表示
                    --}}
                    {{$post->created_at}} / {{$post->user->name}}
                </p>
            </div>
        </div>
        @endforeach
    </div>
</x-app-layout>
