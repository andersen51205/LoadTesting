<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <a class="btn nav-link mt-3 py-0"
                        href="{{ route('TestResultOverview_View', $data['testScriptData']['id']) }}">
                    結果總覽
                </a>
                {{-- <a class="nav-link collapsed" href="#"
                    data-bs-toggle="collapse" data-bs-target="#collapseLayouts"
                    aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fa fa-bar-chart-o fa-fw"></i></div>
                    檢視圖表
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <button class="nav-link" onclick="">時間圖</button>
                        <button class="nav-link" onclick="">流量圖</button>
                        <button class="nav-link" onclick="">反應圖</button>
                    </nav>
                </div> --}}
            </div>
        </div>
        {{-- <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            Start Bootstrap
        </div> --}}
    </nav>
</div>
