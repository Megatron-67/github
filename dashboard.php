<?php
session_start();
if (!isset($_SESSION['user'])) { header("Location: login.php"); exit(); }
$db = new PDO('sqlite:users.db');

// Count total users to show as "Collaborators"
$userCount = $db->query("SELECT COUNT(*) FROM users")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { 
            margin: 0; 
            background-color: #0d1117; 
            color: #c9d1d9; 
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif;
            display: flex;
            height: 100vh;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 260px;
            background-color: #161b22;
            border-right: 1px solid #30363d;
            padding: 24px 16px;
            display: flex;
            flex-direction: column;
        }
        .user-info { display: flex; align-items: center; gap: 10px; margin-bottom: 30px; font-weight: 600; font-size: 14px; }
        .avatar { width: 32px; height: 32px; background: #30363d; border-radius: 50%; display: flex; align-items: center; justify-content: center; }
        
        .nav-item { 
            display: flex; align-items: center; gap: 8px; 
            padding: 8px 12px; border-radius: 6px; 
            text-decoration: none; color: #c9d1d9; font-size: 14px; margin-bottom: 4px;
        }
        .nav-item:hover { background-color: #21262d; }
        .nav-item.active { background-color: #1f6feb; color: white; }

        /* Main Content */
        .main-content { flex: 1; overflow-y: auto; padding: 32px 40px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
        .btn-new { background-color: #238636; color: white; border: 1px solid rgba(240,246,252,0.1); padding: 5px 12px; border-radius: 6px; font-size: 12px; font-weight: 600; cursor: pointer; }
        
        /* Dashboard Grid */
        .grid { display: grid; grid-template-columns: 2fr 1fr; gap: 24px; }
        .card { background-color: #161b22; border: 1px solid #30363d; border-radius: 6px; padding: 20px; margin-bottom: 24px; }
        .card-header { font-size: 14px; font-weight: 600; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
        
        /* Stats Table */
        .project-item { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #30363d; }
        .project-item:last-child { border: none; }
        .status-dot { width: 8px; height: 8px; border-radius: 50%; display: inline-block; background: #3fb950; margin-right: 4px; }
        
        .stat-huge { font-size: 32px; font-weight: 700; color: #f0f6fc; }
        .logout-btn { margin-top: auto; color: #f85149; font-size: 13px; text-decoration: none; padding: 10px; }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="user-info">
            <div class="avatar"><i data-lucide="user" size="18"></i></div>
            <span><?php echo htmlspecialchars($_SESSION['user']); ?></span>
        </div>
        
        <a href="#" class="nav-item active"><i data-lucide="layout"></i> Dashboard</a>
        <a href="#" class="nav-item"><i data-lucide="book-open"></i> Repositories</a>
        <a href="#" class="nav-item"><i data-lucide="layers"></i> Projects</a>
        <a href="#" class="nav-item"><i data-lucide="settings"></i> Settings</a>
        
        <a href="logout.php" class="logout-btn"><i data-lucide="log-out" style="vertical-align: middle; width: 14px;"></i> Sign out</a>
    </div>

    <div class="main-content">
        <div class="header">
            <h1 style="font-size: 20px; font-weight: 600;">Project Overview</h1>
            <button class="btn-new">New Project</button>
        </div>

        <div class="grid">
            <div class="left-col">
                <div class="card">
                    <div class="card-header"><i data-lucide="activity"></i> Recent Activity</div>
                    <div class="project-item">
                        <div><strong>Main_Module.luau</strong><br><span style="font-size: 12px; color: #8b949e;">Updated 2 hours ago</span></div>
                        <span style="font-size: 12px; color: #8b949e;">v1.4.2</span>
                    </div>
                    <div class="project-item">
                        <div><strong>UI_Library.css</strong><br><span style="font-size: 12px; color: #8b949e;">Pushed by admin</span></div>
                        <span style="font-size: 12px; color: #8b949e;">v0.9.0</span>
                    </div>
                    <div class="project-item">
                        <div><strong>Database_Sync.php</strong><br><span style="font-size: 12px; color: #8b949e;">Merged pull request #4</span></div>
                        <span style="font-size: 12px; color: #8b949e;">Success</span>
                    </div>
                </div>
            </div>

            <div class="right-col">
                <div class="card">
                    <div class="card-header"><i data-lucide="users"></i> Collaborators</div>
                    <div class="stat-huge"><?php echo $userCount; ?></div>
                    <p style="font-size: 12px; color: #8b949e;">Total registered developers on this server.</p>
                </div>

                <div class="card">
                    <div class="card-header"><i data-lucide="zap"></i> System Status</div>
                    <div style="font-size: 13px;">
                        <p><span class="status-dot"></span> Database: <span style="color: #3fb950">Online</span></p>
                        <p><span class="status-dot"></span> PHP Server: <span style="color: #3fb950">Running</span></p>
                        <p><span class="status-dot" style="background: #f1e05a"></span> API Latency: 24ms</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>