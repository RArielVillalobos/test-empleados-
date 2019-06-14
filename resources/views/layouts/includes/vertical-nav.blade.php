<div class="card">
    <div class="card-header">
        {{ucwords(auth()->user()->role->description)}}
    </div>
    <div class="card-body">
        <ul class="nav nav-pills flex-column">
            <li class="nav-item">
                <a class="nav-link" href="{{route('home')}}">Home</a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{active_class(route('report.index'))}}" href="{{route('report.index')}}">Reportes</a>
            </li>
            @if(auth()->user()->has_role(1))
            <li class="nav-item">
                <a class="nav-link {{active_class(route('user.index'))}}" href="{{route('user.index')}}">Usuarios</a>
            </li>
            @endif

        </ul>

    </div>

</div>
