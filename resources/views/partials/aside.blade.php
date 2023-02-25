<div id="layoutSidenav_nav">
    <nav class="sidenav shadow-right sidenav-light">
        <div class="sidenav-menu">
            <div class="nav accordion" id="side-nav">
                <div class="sidenav-menu-heading">Home</div>
                <x-aside-link :href="route('report.commission')" title="Commission Report">
                    <x-slot name="icon">
                        <i class="fa fa-table"></i>
                    </x-slot>
                </x-aside-link>
                <x-aside-link :href="route('report.distributor')" title="Distributors Report">
                    <x-slot name="icon">
                        <i class="fa fa-bar-chart"></i>
                    </x-slot>
                </x-aside-link>
            </div>
        </div>
        <div class="sidenav-footer">
            <div class="sidenav-footer-content">
                <div class="sidenav-footer-subtitle"></div>
                <div class="sidenav-footer-title">
                </div>
            </div>
        </div>
    </nav>
</div>
