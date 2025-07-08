<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            フォーム
        </h2>
    </x-slot>
    
    <div class="max-w-7xl mx-auto px-6">
        {{--
            セッションに'message'というキーで保存されたメッセージがある場合、
            そのメッセージを表示します。
        --}}
        {{-- @if (session('message'))
            <div class="text-red-600 font-bold">
                {{ session('message') }}
            </div>
        @endif --}}
        <x-updatemessage :message="session('message')" />
        {{--
            以下のフォームを送信（リクエスト）すると、action属性で指定された
            post.updateというルート名に対応するルートを呼び出す
            引数にこのpostのデータのidを渡す
            また、method属性にpatchメソッドが指定されているため、
            post.updateルートのメソッドはpatchである必要がある
        --}}
        <form method="post" action="{{route('post.update',$post)}}">
            @csrf
            @method('patch')
            <div class="mt-8">
                <div class="w-full flex flex-col">
                    <label for="title" class="font-semibold mt-4">件名</label>
                    {{--
                        バリデーションエラーの表示
                            設定したバリデーションに一致しない値がリクエストされたとき、view側にエラー内容が格納された
                            $error変数が返されます。
                            以下はinput-errorコンポーネントを用いて、エラーの場合titleのエラー内容を抽出し表示します。

                            また、更新時のold関数は第一引数にname属性の値、第二引数にデフォルトの値とする
                    --}}
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    <input type="text" name="title" class="w-auto py-2 border border-gray-300 rounded-md" id="title"
                    value="{{old('title',$post->title)}}">
                </div>
            </div>

            <div class="w-full flex flex-col">
                <label for="body" class="font-semibold mt-4">本文</label>
                {{--    
                    以下は上記同様にbodyのエラー内容を抽出し表示します。

                    また、old関数を用いてinputに入力したバリデーションエラー前の値を残します。
                --}}
                <x-input-error :messages="$errors->get('body')" class="mt-2" />
                <textarea name="body" class="w-auto py-2 border border-gray-300 rounded-md" id="body" cols="30" rows="5">
                    {{old('body',$post->body)}}
                </textarea>
            </div>

            <x-primary-button class="mt-4">
                送信する
            </x-primary-button>
        </form>
    </div>
</x-app-layout>
