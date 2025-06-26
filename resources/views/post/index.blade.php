<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            一覧表示
        </h2>
    </x-slot>
    
    <div class="mx-auto px-6">
        {{-- postsテーブルの各データごとにforeachで処理を回す --}}
        @foreach ($posts as $post)
        <div class="mt-4 p-8 bg-green-300 w-full rounded-2xl">
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
                        3.Eloquent(ORM)でuser_idに一致する主キーのユーザー名を取得
                        4.取得した日時とユーザー名の値を表示
                    --}}
                    {{$post->created_at}} / {{$post->user->name}}
                </p>
            </div>
        </div>
        @endforeach
    </div>
    <div class="mx-auto px-6">
        {{-- postsテーブルの各データごとにforeachで処理を回す --}}
        <h1 class="mt-12 text-xl font-bold">条件付き表示</h1>
        @foreach ($terms as $term)
        <div class="mt-4 p-8 bg-blue-300 w-full rounded-2xl">
            <h1 class="p-4 text-lg font-semibold">
                {{-- titleを取得し表示 --}}
                {{$term->title}}
            </h1>
            <hr class="w-full">
            <p class="mt-4 p-4">
                {{-- bodyを取得し表示 --}}
                {{$term->body}}
            </p>
            <div class="p-4 text-sm font-semibold">
                <p>
                    {{--以下の処理
                        1.Postモデルを介して投稿した日時(created_atカラムの値)を取得
                        2.Postモデルのuserメソッドでリレーションしたuserモデル参照し
                        3.Eloquent(ORM)でuser_idに一致する主キーのユーザー名を取得
                        4.取得した日時とユーザー名の値を表示
                    --}}
                    {{$term->created_at}} / {{$term->user->name}}
                </p>
            </div>
        </div>
        @endforeach
    </div>
</x-app-layout>
