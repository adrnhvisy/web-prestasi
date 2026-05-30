<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    
    <!-- Sidebar Brand -->
    <div class="sidebar-brand">
        <a href="{{ route('dashboard') }}" class="brand-link">
            <img src="{{ asset('assets/storage/logo.png') }}" alt="E-Point Logo" class="brand-image opacity-75 shadow " style="border-radius: 12px; object-fit: cover;">
            <span class="brand-text fw-light">E-Point SMK</span>
        </a>
    </div>

    <!-- Sidebar Wrapper -->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview">
                
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-speedometer2"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- MASTER DATA -->
                <li class="nav-item {{ request()->routeIs('master-data.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-database-fill"></i>
                        <p>
                            Master Data
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <!-- Jurusan -->
                        <li class="nav-item">
                            <a href="{{ route('master-data.jurusan.index') }}" class="nav-link {{ request()->routeIs('master-data.jurusan.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-building"></i>
                                <p>Jurusan</p>
                            </a>
                        </li>

                        <!-- Kelas -->
                        <li class="nav-item">
                            <a href="{{ route('master-data.kelas.index') }}" class="nav-link {{ request()->routeIs('master-data.kelas.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-people-fill"></i>
                                <p>Kelas</p>
                            </a>
                        </li>

                        <!-- Tahun Ajaran -->
                        <li class="nav-item">
                            <a href="{{ route('master-data.tahun-ajaran.index') }}" class="nav-link {{ request()->routeIs('master-data.tahun-ajaran.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-calendar-check"></i>
                                <p>Tahun Ajaran</p>
                            </a>
                        </li>

                        <!-- Kategori Pelanggaran -->
                        <li class="nav-item">
                            <a href="{{ route('master-data.kategori-pelanggaran.index') }}" 
                               class="nav-link {{ request()->routeIs('master-data.kategori-pelanggaran.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-exclamation-triangle"></i>
                                <p>Kategori Pelanggaran</p>
                            </a>
                        </li>

                        <!-- Jenis Pelanggaran -->
                        <li class="nav-item">
                            <a href="{{ route('master-data.pelanggaran.index') }}" 
                               class="nav-link {{ request()->routeIs('master-data.pelanggaran.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-exclamation-circle"></i>
                                <p>Jenis Pelanggaran</p>
                            </a>
                        </li>

                        <!-- Kategori Prestasi -->
                        <li class="nav-item">
                            <a href="{{ route('master-data.kategori-prestasi.index') }}" 
                               class="nav-link {{ request()->routeIs('master-data.kategori-prestasi.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-trophy"></i>
                                <p>Kategori Prestasi</p>
                            </a>
                        </li>

                        <!-- Jenis Prestasi -->
                        <li class="nav-item">
                            <a href="{{ route('master-data.prestasi.index') }}" 
                               class="nav-link {{ request()->routeIs('master-data.prestasi.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-star-fill"></i>
                                <p>Jenis Prestasi</p>
                            </a>
                        </li>

                        <!-- Data Guru -->
                        <li class="nav-item">
                            <a href="{{ route('master-data.guru.index') }}" class="nav-link {{ request()->routeIs('master-data.guru.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-person-badge"></i>
                                <p>Data Guru</p>
                            </a>
                        </li>

                        <!-- Data Siswa -->
                        <li class="nav-item">
                            <a href="{{ route('master-data.siswa.index') }}" class="nav-link {{ request()->routeIs('master-data.siswa.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-person-vcard"></i>
                                <p>Data Siswa</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- MANAGEMENT ACCESS -->
                <li class="nav-item {{ request()->routeIs('management-access.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-shield-lock-fill"></i>
                        <p>
                            Management Access
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <!-- Users -->
                        <li class="nav-item">
                            <a href="{{ route('management-access.users.index') }}" class="nav-link {{ request()->routeIs('management-access.users.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-people"></i>
                                <p>Users</p>
                            </a>
                        </li>
                    </ul>       
                </li>
                        
                <!-- OPERASIONAL -->
                <li class="nav-item {{ request()->routeIs('operasional.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-gear-fill"></i>
                        <p>
                            Operasional
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <!-- Penempatan Kelas -->
                        <li class="nav-item">
                            <a href="{{ route('operasional.kelas-siswa.index') }}" class="nav-link {{ request()->routeIs('operasional.kelas-siswa.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-person-plus"></i>
                                <p>Penempatan Kelas</p>
                            </a>
                        </li>

                        <!-- Input Pelanggaran -->
                        <li class="nav-item">
                            <a href="{{ route('operasional.input-pelanggaran.index') }}" class="nav-link {{ request()->routeIs('operasional.input-pelanggaran.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-exclamation-circle text-danger"></i>
                                <p>Input Pelanggaran</p>
                            </a>
                        </li>

                        <!-- Input Prestasi -->
                        <li class="nav-item">
                            <a href="{{ route('operasional.input-prestasi.index') }}" class="nav-link {{ request()->routeIs('operasional.input-prestasi.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-star-fill text-success"></i>
                                <p>Input Prestasi</p>
                            </a>
                        </li>

                        <!-- Log Aktivitas -->
                        <li class="nav-item">
                            <a href="{{ route('operasional.log-aktivitas.index') }}" class="nav-link {{ request()->routeIs('operasional.log-aktivitas.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-clock-history"></i>
                                <p>Log Aktivitas</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- LAPORAN -->
                <li class="nav-item {{ request()->routeIs('reports.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-file-earmark-bar-graph"></i>
                        <p>
                            Laporan
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <!-- Rekap Siswa -->
                        <li class="nav-item">
                            <a href="{{ route('reports.siswa.rekap') }}" class="nav-link {{ request()->routeIs('reports.siswa.rekap') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-person-lines-fill"></i>
                                <p>Rekap Siswa</p>
                            </a>
                        </li>

                        <!-- Rekap Kelas -->
                        <li class="nav-item">
                            <a href="{{ route('reports.kelas.rekap') }}" class="nav-link {{ request()->routeIs('reports.kelas.rekap') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-people"></i>
                                <p>Rekap Kelas</p>
                            </a>
                        </li>

                        <!-- Ranking -->
                        <li class="nav-item">
                            <a href="{{ route('reports.ranking.index') }}" class="nav-link {{ request()->routeIs('reports.ranking.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-trophy-fill"></i>
                                <p>Ranking</p>
                            </a>
                        </li>
                        
                        <!-- Ranking Per Kelas -->
                        <li class="nav-item">
                            <a href="{{ route('reports.ranking.per-kelas', ['kelas' => 1]) }}" class="nav-link {{ request()->routeIs('reports.ranking.per-kelas') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-trophy-fill"></i>
                                <p>Ranking Per Kelas</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Profile -->
                <li class="nav-item">
                    <a href="{{ route('profile.index') }}" class="nav-link {{ request()->routeIs('profile.index') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-person-circle"></i>
                        <p>Profile Saya</p>
                    </a>
                </li> 

            </ul>
        </nav>
    </div>
</aside>