<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            一覧表示
        </h2>
    </x-slot>

    {{-- 投稿日検索（カレンダーUI） --}}
    <div class="flex justify-between items-center pt-4 px-6">
        <form method="GET" action="{{ route('post.index') }}">
            <input type="text" id="datePicker" name="date" placeholder="日付を選択" value="{{ request('date') }}"
            class="py-2 border border-gray-300 rounded-md">
            <x-primary-button type="submit">表 示</x-primary-button>
        </form>
        <script>
            flatpickr("#datePicker", {
                dateFormat: "Y-m-d",
                locale: "ja"
            });
        </script>
        @if (request('date'))
        <p class="text-gray-500">表示中: {{ request('date') }} の記事</p>
        @else
        <p class="text-gray-500">表示中: 全ての記事</p>
        @endif
    </div>

    <div class="mx-auto px-6">
        {{-- @if (session('message'))
            <div class="text-red-600 font-bold">
                {{ session('message') }}
            </div>
        @endif --}}
        <x-message :message="session('message')" />
        {{-- postsテーブルの各データごとにforeachで処理を回す --}}
        @foreach ($posts as $post)
        <div class="post opacity-0 translate-y-8 transition-all duration-700 ease-out
        mt-4 p-8 bg-white w-full rounded-2xl">
            <h1 class="p-4 text-lg font-semibold">
                {{--
                    リンクのURLを生成するためのrouteを呼び出し、パラメーターの
                    引数としてPostモデルを介して取得したデータのidを渡す（routes/web.phpへ）
                        ※$postはレコードを格納しているが、Laravelではヘルパー関数route()
                        で呼び出すとURL生成のために内部的に[$post->getRouteKey()]となり
                        idが返される
                --}}
                <a href="{{route('post.show',$post)}}">
                    {{-- titleを取得し表示 --}}
                    {{$post->title}}
                </a>
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
        <div class="pt-4">
            {{$posts->links()}}
        </div>
    </div>

    {{-- <div class="mx-auto px-6">
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
    </div> --}}
</x-app-layout>
