@extends(theme_extends())

@section('content')
	
<main class="notfound" id="main">
        <div class="container">
            <section>
                <h2 class="main-title">404</h2>
                <p>Không tìm thấy trang</p>
                <a href="{!!route('index')!!}" class="btn main round">Trang chủ</a>
            </section>
        </div>
    </main>
	
@stop