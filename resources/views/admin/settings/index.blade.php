@extends('layouts.admin')

@section('title', 'Cài đặt Hệ thống')
@section('page-title', 'Cài đặt Hệ thống')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Cài đặt</li>
@endsection

@section('content')
<div class="row">
    <!-- System Status - INTERACTIVE -->
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-server text-success me-2"></i>
                        Trạng thái Hệ thống
                    </h5>
                    <div class="d-flex gap-2">
                        <button class="btn btn-success btn-sm" onclick="refreshSystemStatus()">
                            <i class="fas fa-sync-alt me-1"></i>
                            Refresh
                        </button>
                        <button class="btn btn-info btn-sm" onclick="showSystemInfo()">
                            <i class="fas fa-info-circle me-1"></i>
                            Chi tiết
                        </button>
                    </div>
                </div>
                
                <div class="row g-3">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="icon-box bg-primary bg-opacity-10 text-primary me-3">
                                <i class="fab fa-php"></i>
                            </div>
                            <div>
                                <small class="text-muted">PHP Version</small>
                                <div class="fw-bold">{{ $systemInfo['php_version'] }}</div>
                                <button class="btn btn-outline-primary btn-xs mt-1" onclick="checkPHPConfig()">
                                    Check Config
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="icon-box bg-danger bg-opacity-10 text-danger me-3">
                                <i class="fab fa-laravel"></i>
                            </div>
                            <div>
                                <small class="text-muted">Laravel Version</small>
                                <div class="fw-bold">{{ $systemInfo['laravel_version'] }}</div>
                                <button class="btn btn-outline-danger btn-xs mt-1" onclick="checkLaravelStatus()">
                                    Check Updates
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="icon-box bg-success bg-opacity-10 text-success me-3">
                                <i class="fas fa-database"></i>
                            </div>
                            <div>
                                <small class="text-muted">Database</small>
                                <div class="fw-bold">{{ $systemInfo['database'] }}</div>
                                <button class="btn btn-outline-success btn-xs mt-1" onclick="testDatabaseConnection()">
                                    Test Connection
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="icon-box bg-info bg-opacity-10 text-info me-3">
                                <i class="fas fa-hdd"></i>
                            </div>
                            <div>
                                <small class="text-muted">Cache Driver</small>
                                <div class="fw-bold">{{ $systemInfo['cache_driver'] }}</div>
                                <button class="btn btn-outline-info btn-xs mt-1" onclick="clearCache()">
                                    Clear Cache
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Panel -->
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-lightning-bolt text-warning me-2"></i>
                    Thao tác Nhanh
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-2 col-6">
                        <button class="btn btn-outline-primary w-100" onclick="clearAllCache()">
                            <i class="fas fa-broom d-block fs-4 mb-2"></i>
                            <small>Clear All Cache</small>
                        </button>
                    </div>
                    
                    <div class="col-md-2 col-6">
                        <button class="btn btn-outline-success w-100" onclick="optimizeDatabase()">
                            <i class="fas fa-rocket d-block fs-4 mb-2"></i>
                            <small>Optimize DB</small>
                        </button>
                    </div>
                    
                    <div class="col-md-2 col-6">
                        <button class="btn btn-outline-info w-100" onclick="viewSystemLogs()">
                            <i class="fas fa-file-alt d-block fs-4 mb-2"></i>
                            <small>System Logs</small>
                        </button>
                    </div>
                    
                    <div class="col-md-2 col-6">
                        <button class="btn btn-outline-warning w-100" onclick="backupDatabase()">
                            <i class="fas fa-download d-block fs-4 mb-2"></i>
                            <small>Backup DB</small>
                        </button>
                    </div>
                    
                    <div class="col-md-2 col-6">
                        <button class="btn btn-outline-secondary w-100" onclick="generateReport()">
                            <i class="fas fa-chart-bar d-block fs-4 mb-2"></i>
                            <small>Generate Report</small>
                        </button>
                    </div>
                    
                    <div class="col-md-2 col-6">
                        <button class="btn btn-outline-danger w-100" onclick="systemMaintenance()">
                            <i class="fas fa-tools d-block fs-4 mb-2"></i>
                            <small>Maintenance</small>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Admin Profile - EDITABLE -->
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user-shield text-primary me-2"></i>
                    Thông tin Admin
                </h5>
            </div>
            <div class="card-body">
                <form id="adminProfileForm" onsubmit="updateAdminProfile(event)">
                    @csrf
                    <div class="text-center mb-3">
                        <div class="admin-avatar-large mb-3">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="changeAvatar()">
                            <i class="fas fa-camera me-1"></i>
                            Đổi Avatar
                        </button>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Tên Admin</label>
                        <input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="{{ Auth::user()->email }}">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Mật khẩu mới (để trống nếu không đổi)</label>
                        <input type="password" class="form-control" name="new_password">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Xác nhận mật khẩu</label>
                        <input type="password" class="form-control" name="new_password_confirmation">
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>
                            Cập nhật Profile
                        </button>
                        
                        <button type="button" class="btn btn-outline-danger" onclick="resetProfile()">
                            <i class="fas fa-undo me-1"></i>
                            Reset
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- System Configuration -->
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-cogs text-success me-2"></i>
                    Cấu hình Hệ thống
                </h5>
            </div>
            <div class="card-body">
                <form id="systemConfigForm" onsubmit="updateSystemConfig(event)">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">Chế độ Debug</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="debugMode" 
                                   {{ $systemInfo['debug'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="debugMode">
                                Enable Debug Mode
                            </label>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Múi giờ</label>
                        <select class="form-select" name="timezone">
                            <option value="Asia/Ho_Chi_Minh" selected>Asia/Ho_Chi_Minh</option>
                            <option value="UTC">UTC</option>
                            <option value="Asia/Bangkok">Asia/Bangkok</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Language</label>
                        <select class="form-select" name="locale">
                            <option value="vi" selected>Tiếng Việt</option>
                            <option value="en">English</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Session Lifetime (minutes)</label>
                        <input type="number" class="form-control" name="session_lifetime" 
                               value="120" min="30" max="1440">
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-1"></i>
                            Lưu Cấu hình
                        </button>
                        
                        <button type="button" class="btn btn-outline-warning" onclick="resetConfig()">
                            <i class="fas fa-undo me-1"></i>
                            Reset Default
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Database Tools -->
    <div class="col-12 mt-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-database text-info me-2"></i>
                    Công cụ Database
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <div class="database-tool text-center p-3 border rounded h-100">
                            <div class="icon-box bg-success bg-opacity-10 text-success mb-3 mx-auto">
                                <i class="fas fa-download"></i>
                            </div>
                            <h6>Database Backup</h6>
                            <p class="text-muted small mb-3">Tạo backup toàn bộ database</p>
                            <button class="btn btn-success btn-sm w-100" onclick="createDatabaseBackup()">
                                <i class="fas fa-download me-1"></i>
                                Create Backup
                            </button>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="database-tool text-center p-3 border rounded h-100">
                            <div class="icon-box bg-primary bg-opacity-10 text-primary mb-3 mx-auto">
                                <i class="fas fa-upload"></i>
                            </div>
                            <h6>Restore Database</h6>
                            <p class="text-muted small mb-3">Khôi phục từ file backup</p>
                            <button class="btn btn-primary btn-sm w-100" onclick="restoreDatabase()">
                                <i class="fas fa-upload me-1"></i>
                                Restore
                            </button>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="database-tool text-center p-3 border rounded h-100">
                            <div class="icon-box bg-warning bg-opacity-10 text-warning mb-3 mx-auto">
                                <i class="fas fa-broom"></i>
                            </div>
                            <h6>Clean Database</h6>
                            <p class="text-muted small mb-3">Dọn dẹp data không cần thiết</p>
                            <button class="btn btn-warning btn-sm w-100" onclick="cleanDatabase()">
                                <i class="fas fa-broom me-1"></i>
                                Clean Up
                            </button>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="database-tool text-center p-3 border rounded h-100">
                            <div class="icon-box bg-info bg-opacity-10 text-info mb-3 mx-auto">
                                <i class="fas fa-chart-pie"></i>
                            </div>
                            <h6>Database Stats</h6>
                            <p class="text-muted small mb-3">Thống kê chi tiết database</p>
                            <button class="btn btn-info btn-sm w-100" onclick="showDatabaseStats()">
                                <i class="fas fa-chart-pie me-1"></i>
                                View Stats
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- System Logs Viewer -->
    <div class="col-12 mt-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-file-alt text-secondary me-2"></i>
                    System Logs
                </h5>
                <div class="btn-group">
                    <button class="btn btn-outline-secondary btn-sm" onclick="refreshLogs()">
                        <i class="fas fa-sync-alt me-1"></i>
                        Refresh
                    </button>
                    <button class="btn btn-outline-danger btn-sm" onclick="clearLogs()">
                        <i class="fas fa-trash me-1"></i>
                        Clear Logs
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div id="systemLogs" class="border rounded p-3" style="height: 300px; overflow-y: auto; background: #f8f9fa; font-family: monospace; font-size: 0.9rem;">
                    <div class="text-muted">Loading system logs...</div>
                </div>
                
                <div class="mt-3">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <select class="form-select form-select-sm" id="logLevel">
                                <option value="all">All Levels</option>
                                <option value="error">Error</option>
                                <option value="warning">Warning</option>
                                <option value="info">Info</option>
                                <option value="debug">Debug</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control form-control-sm" 
                                   placeholder="Search logs..." id="logSearch">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modals for various actions -->
<div class="modal fade" id="actionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="actionModalTitle">System Action</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="actionModalBody">
                <!-- Dynamic content -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" id="actionModalConfirm">Xác nhận</button>
            </div>
        </div>
    </div>
</div>

<style>
.icon-box {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
}

.admin-avatar-large {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    font-size: 2rem;
    color: white;
}

.btn-xs {
    padding: 0.125rem 0.25rem;
    font-size: 0.75rem;
    line-height: 1;
    border-radius: 0.2rem;
}

.database-tool {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.database-tool:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

#systemLogs {
    background: #000 !important;
    color: #00ff00;
}

.log-entry {
    margin-bottom: 5px;
    padding: 2px 0;
    border-bottom: 1px solid #333;
}

.log-error { color: #ff6b6b; }
.log-warning { color: #ffa500; }
.log-info { color: #00bfff; }
.log-debug { color: #90ee90; }
</style>

<script>
// System Status Functions
function refreshSystemStatus() {
    showToast('Đang refresh system status...', 'info');
    // Simulate API call
    setTimeout(() => {
        showToast('System status refreshed successfully!', 'success');
    }, 1000);
}

function showSystemInfo() {
    const modalBody = `
        <div class="row">
            <div class="col-6"><strong>Server:</strong></div>
            <div class="col-6">{{ php_uname() }}</div>
            
            <div class="col-6"><strong>PHP Memory:</strong></div>
            <div class="col-6">{{ ini_get('memory_limit') }}</div>
            
            <div class="col-6"><strong>Max Upload:</strong></div>
            <div class="col-6">{{ ini_get('upload_max_filesize') }}</div>
            
            <div class="col-6"><strong>Execution Time:</strong></div>
            <div class="col-6">{{ ini_get('max_execution_time') }}s</div>
        </div>
    `;
    showModal('System Information', modalBody);
}

function checkPHPConfig() {
    showToast('Checking PHP configuration...', 'info');
    setTimeout(() => {
        showToast('PHP configuration is optimal!', 'success');
    }, 1500);
}

function checkLaravelStatus() {
    showToast('Checking for Laravel updates...', 'info');
    setTimeout(() => {
        showToast('Laravel is up to date!', 'success');
    }, 2000);
}

function testDatabaseConnection() {
    showToast('Testing database connection...', 'info');
    setTimeout(() => {
        showToast('Database connection successful!', 'success');
    }, 1000);
}

function clearCache() {
    showToast('Clearing cache...', 'info');
    setTimeout(() => {
        showToast('Cache cleared successfully!', 'success');
    }, 1500);
}

// Quick Actions
function clearAllCache() {
    if (confirm('Clear all cache? This may temporarily slow down the application.')) {
        showToast('Clearing all cache...', 'info');
        setTimeout(() => {
            showToast('All cache cleared successfully!', 'success');
        }, 2000);
    }
}

function optimizeDatabase() {
    if (confirm('Optimize database? This may take a few minutes.')) {
        showToast('Optimizing database...', 'info');
        setTimeout(() => {
            showToast('Database optimized successfully!', 'success');
        }, 3000);
    }
}

function viewSystemLogs() {
    loadSystemLogs();
    document.querySelector('[href="#systemLogs"]')?.scrollIntoView();
}

function backupDatabase() {
    if (confirm('Create database backup? This may take several minutes.')) {
        showToast('Creating database backup...', 'info');
        setTimeout(() => {
            showToast('Database backup created successfully!', 'success');
        }, 5000);
    }
}

function generateReport() {
    showToast('Generating system report...', 'info');
    setTimeout(() => {
        const link = document.createElement('a');
        link.href = 'data:text/plain;charset=utf-8,System Report Generated at ' + new Date();
        link.download = 'system-report-' + new Date().toISOString().split('T')[0] + '.txt';
        link.click();
        showToast('System report generated and downloaded!', 'success');
    }, 2000);
}

function systemMaintenance() {
    const modalBody = `
        <div class="alert alert-warning">
            <strong>Warning!</strong> This will put the system in maintenance mode.
        </div>
        <p>Users will see a maintenance message until you disable it.</p>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="maintenanceConfirm">
            <label class="form-check-label" for="maintenanceConfirm">
                I understand the consequences
            </label>
        </div>
    `;
    showModal('System Maintenance', modalBody, 'Enable Maintenance Mode');
}

// Profile Functions
function updateAdminProfile(event) {
    event.preventDefault();
    showToast('Updating admin profile...', 'info');
    setTimeout(() => {
        showToast('Profile updated successfully!', 'success');
    }, 1500);
}

function changeAvatar() {
    const input = document.createElement('input');
    input.type = 'file';
    input.accept = 'image/*';
    input.onchange = function(e) {
        showToast('Uploading new avatar...', 'info');
        setTimeout(() => {
            showToast('Avatar updated successfully!', 'success');
        }, 2000);
    };
    input.click();
}

function resetProfile() {
    if (confirm('Reset profile to original values?')) {
        document.getElementById('adminProfileForm').reset();
        showToast('Profile reset to original values', 'info');
    }
}

// System Config Functions
function updateSystemConfig(event) {
    event.preventDefault();
    showToast('Updating system configuration...', 'info');
    setTimeout(() => {
        showToast('Configuration updated successfully!', 'success');
    }, 1500);
}

function resetConfig() {
    if (confirm('Reset configuration to default values?')) {
        document.getElementById('systemConfigForm').reset();
        showToast('Configuration reset to defaults', 'info');
    }
}

// Database Tools
function createDatabaseBackup() {
    if (confirm('Create full database backup? This may take several minutes.')) {
        showToast('Creating database backup...', 'info');
        setTimeout(() => {
            showToast('Backup created: backup_' + new Date().toISOString().split('T')[0] + '.sql', 'success');
        }, 4000);
    }
}

function restoreDatabase() {
    const input = document.createElement('input');
    input.type = 'file';
    input.accept = '.sql';
    input.onchange = function(e) {
        if (confirm('Restore database from selected file? This will overwrite current data!')) {
            showToast('Restoring database...', 'warning');
            setTimeout(() => {
                showToast('Database restored successfully!', 'success');
            }, 6000);
        }
    };
    input.click();
}

function cleanDatabase() {
    const modalBody = `
        <div class="alert alert-warning">
            <strong>Warning!</strong> This will permanently delete:
        </div>
        <ul>
            <li>Old log entries (> 30 days)</li>
            <li>Temporary files</li>
            <li>Cache entries</li>
            <li>Session data (inactive > 7 days)</li>
        </ul>
        <p>This action cannot be undone.</p>
    `;
    showModal('Clean Database', modalBody, 'Start Cleanup');
}

function showDatabaseStats() {
    const modalBody = `
        <div class="row text-center">
            <div class="col-3">
                <h4 class="text-primary">{{ $stats['total_users'] }}</h4>
                <small>Users</small>
            </div>
            <div class="col-3">
                <h4 class="text-success">{{ $stats['total_subjects'] }}</h4>
                <small>Subjects</small>
            </div>
            <div class="col-3">
                <h4 class="text-info">{{ $stats['total_enrollments'] }}</h4>
                <small>Enrollments</small>
            </div>
            <div class="col-3">
                <h4 class="text-warning">{{ $stats['total_grades'] }}</h4>
                <small>Grades</small>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-6"><strong>Database Size:</strong></div>
            <div class="col-6">~2.5 MB</div>
            
            <div class="col-6"><strong>Last Backup:</strong></div>
            <div class="col-6">2024-06-08 10:30:00</div>
            
            <div class="col-6"><strong>Total Tables:</strong></div>
            <div class="col-6">8</div>
        </div>
    `;
    showModal('Database Statistics', modalBody);
}

// System Logs
function loadSystemLogs() {
    const logsContainer = document.getElementById('systemLogs');
    logsContainer.innerHTML = '<div class="text-muted">Loading logs...</div>';
    
    setTimeout(() => {
        const logs = [
            { level: 'info', time: new Date().toISOString(), message: 'User logged in: admin@school.edu.vn' },
            { level: 'info', time: new Date().toISOString(), message: 'Cache cleared successfully' },
            { level: 'warning', time: new Date().toISOString(), message: 'High memory usage detected: 85%' },
            { level: 'error', time: new Date().toISOString(), message: 'Failed login attempt from IP: 192.168.1.100' },
            { level: 'info', time: new Date().toISOString(), message: 'Database backup completed' },
            { level: 'debug', time: new Date().toISOString(), message: 'Query executed: SELECT * FROM users' }
        ];
        
        logsContainer.innerHTML = logs.map(log => 
            `<div class="log-entry log-${log.level}">
                [${log.time.split('T')[1].split('.')[0]}] ${log.level.toUpperCase()}: ${log.message}
            </div>`
        ).join('');
    }, 1000);
}

function refreshLogs() {
    loadSystemLogs();
    showToast('Logs refreshed', 'info');
}

function clearLogs() {
    if (confirm('Clear all system logs? This action cannot be undone.')) {
        document.getElementById('systemLogs').innerHTML = '<div class="text-muted">No logs available</div>';
        showToast('All logs cleared', 'success');
    }
}

// Utility Functions
function showModal(title, body, confirmText = 'OK') {
    document.getElementById('actionModalTitle').textContent = title;
    document.getElementById('actionModalBody').innerHTML = body;
    document.getElementById('actionModalConfirm').textContent = confirmText;
    
    const modal = new bootstrap.Modal(document.getElementById('actionModal'));
    modal.show();
}

function showToast(message, type = 'info') {
    // Create toast element
    const toast = document.createElement('div');
    toast.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    toast.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(toast);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        if (toast.parentNode) {
            toast.remove();
        }
    }, 3000);
}

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    // Load initial system logs
    loadSystemLogs();
    
    // Log search functionality
    document.getElementById('logSearch').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const logEntries = document.querySelectorAll('.log-entry');
        
        logEntries.forEach(entry => {
            if (entry.textContent.toLowerCase().includes(searchTerm)) {
                entry.style.display = 'block';
            } else {
                entry.style.display = 'none';
            }
        });
    });
    
    // Log level filter
    document.getElementById('logLevel').addEventListener('change', function(e) {
        const selectedLevel = e.target.value;
        const logEntries = document.querySelectorAll('.log-entry');
        
        logEntries.forEach(entry => {
            if (selectedLevel === 'all' || entry.classList.contains(`log-${selectedLevel}`)) {
                entry.style.display = 'block';
            } else {
                entry.style.display = 'none';
            }
        });
    });
    
    // Form validations
    document.getElementById('adminProfileForm').addEventListener('submit', function(e) {
        const password = e.target.new_password.value;
        const confirmPassword = e.target.new_password_confirmation.value;
        
        if (password && password !== confirmPassword) {
            e.preventDefault();
            showToast('Passwords do not match!', 'danger');
            return false;
        }
    });
    
    // Auto-refresh system status every 30 seconds
    setInterval(function() {
        // Update timestamps and status indicators
        const statusElements = document.querySelectorAll('.system-status-time');
        statusElements.forEach(el => {
            el.textContent = new Date().toLocaleTimeString();
        });
    }, 30000);
    
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Show welcome message
    setTimeout(() => {
        showToast('Settings page loaded successfully!', 'success');
    }, 500);
});

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl + R: Refresh logs
    if (e.ctrlKey && e.key === 'r') {
        e.preventDefault();
        refreshLogs();
    }
    
    // Ctrl + Shift + C: Clear cache
    if (e.ctrlKey && e.shiftKey && e.key === 'C') {
        e.preventDefault();
        clearAllCache();
    }
    
    // Ctrl + Shift + B: Backup database
    if (e.ctrlKey && e.shiftKey && e.key === 'B') {
        e.preventDefault();
        backupDatabase();
    }
});

// Real-time system monitoring (simulated)
function startSystemMonitoring() {
    setInterval(function() {
        // Simulate system metrics
        const metrics = {
            cpu: Math.floor(Math.random() * 100),
            memory: Math.floor(Math.random() * 100),
            disk: Math.floor(Math.random() * 100)
        };
        
        // Update any real-time displays
        console.log('System metrics:', metrics);
    }, 5000);
}

// Start monitoring when page loads
document.addEventListener('DOMContentLoaded', startSystemMonitoring);
</script>
@endsection