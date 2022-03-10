<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                {{-- 標題 --}}
                {{-- <div class="sb-sidenav-menu-heading">專案列表</div> --}}
                {{-- 內容 --}}
                {{-- <a class="nav-link" href="index.html">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a> --}}
                {{-- 摺疊式內容 --}}
                {{-- <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                    data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Layouts
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="layout-static.html">Static Navigation</a>
                        <a class="nav-link" href="layout-sidenav-light.html">Light Sidenav</a>
                    </nav>
                </div> --}}
                <div class="sb-sidenav-menu-heading">專案列表</div>
                @if(isset($data['projectList']))
                    @foreach ($data['projectList'] as $project)
                        <a class="btn nav-link" href="{{ route('Project_View', [$project['name']]) }}">
                            {{ $project['name'] }}
                        </a>
                    @endforeach
                @endif
                {{-- <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                    data-bs-target="#collapseProject1" aria-expanded="false" aria-controls="collapseProject1">
                    專案1
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseProject1" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="layout-static.html">
                            <i class="fa-solid fa-scroll"></i> 測試腳本1
                        </a>
                        <a class="nav-link" href="layout-sidenav-light.html">
                            <i class="fa-solid fa-scroll"></i> 測試腳本2
                        </a>
                    </nav>
                </div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                    data-bs-target="#collapseProject2" aria-expanded="false" aria-controls="collapseProject2">
                    專案2
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseProject2" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="layout-static.html">
                            <i class="fa-solid fa-scroll"></i> 測試腳本1
                        </a>
                        <a class="nav-link" href="layout-sidenav-light.html">
                            <i class="fa-solid fa-scroll"></i> 測試腳本2
                        </a>
                    </nav>
                </div> --}}
                <a class="btn nav-link" href="{{ route('ProjectCreate_View') }}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-plus"></i></div>
                    新增專案
                </a>
            </div>
        </div>
        {{-- <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            Start Bootstrap
        </div> --}}
    </nav>
</div>
