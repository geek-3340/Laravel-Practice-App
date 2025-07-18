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
        <x-message :message="session('message')" />
        {{--
            以下のフォームのを送信（リクエスト）すると、action属性で指定された
            URLまたはルート名に対応するルートが呼び出されます。
            ここでは、post.storeという名前のルートが呼び出されます。
            また、method属性でPOSTメソッドが指定されているため、
            post.storeルートのメソッドはPOSTである必要があります。
        --}}
        <form method="post" action="{{route('post.store')}}">
            @csrf
            <div class="mt-8">
                <div class="w-full flex flex-col">
                    <label for="title" class="font-semibold mt-4">件名</label>
                    {{--
                        バリデーションエラーの表示
                            設定したバリデーションに一致しない値がリクエストされたとき、view側にエラー内容が格納された
                            $error変数が返されます。
                            以下はinput-errorコンポーネントを用いて、エラーの場合titleのエラー内容を抽出し表示します。

                            また、old関数を用いてinputに入力したバリデーションエラー前の値を残します。
                    --}}
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    <input type="text" name="title" class="w-auto py-2 border border-gray-300 rounded-md" id="title"
                    value="{{old('title')}}">
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
                    {{old('body')}}
                </textarea>
            </div>

            <x-primary-button class="mt-4">
                送信する
            </x-primary-button>
        </form>
    </div>
</x-app-layout>
