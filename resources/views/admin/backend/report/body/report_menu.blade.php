<div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a href="{{ route('all.report') }}" class="nav-link active" aria-current="page"> Purchase</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('purchase.return.report') }}" class="nav-link purchase-return-tab"> Purchase Return</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('sales.report') }}" class="nav-link"> Sale</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('sales.return.report') }}" class="nav-link"> Sale Return</a>
        </li>
        <li class="nav-item">
            <a href="{{route('product.stock.report')}}" class="nav-link"> Stock</a>
        </li>
    </ul>
</div>
