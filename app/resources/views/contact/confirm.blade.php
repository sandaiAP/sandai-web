<section class="content">
    <div class="box grid-box">
        <form method="POST" action="{{ route('contact.thanks') }}">
            @csrf

            <label>メールアドレス</label>
            {{ $inputs['email'] }}
            <input
                name="email"
                value="{{ $inputs['email'] }}"
                type="hidden">

            <label>お名前</label>
            {{ $inputs['name'] }}
            <input
                name="name"
                value="{{ $inputs['name'] }}"
                type="hidden">


            <label>お問い合わせ内容</label>
            {!! nl2br(e($inputs['body'])) !!}
            <input
                name="body"
                value="{{ $inputs['body'] }}"
                type="hidden">

            <button type="submit" name="action" value="back">
                入力内容修正
            </button>
            <button type="submit" name="action" value="submit">
                送信する
            </button>
        </form>
    </div>
</section>
