<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php($appBrand = config('app.name', 'My Tasks'))
    <title>@yield('title', $appBrand)</title>
    <style>
        :root {
            --ink: #22313f;
            --muted: #6d746d;
            --line: #d9e0e7;
            --accent: #0f766e;
            --danger: #b91c1c;
            --success: #166534;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Trebuchet MS", "Segoe UI", sans-serif;
            color: var(--ink);
            background: #f4f6f8;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .shell {
            width: min(1120px, calc(100% - 32px));
            margin: 0 auto;
            padding: 28px 0 48px;
        }

        .topbar,
        .card,
        .stat,
        .task-card,
        .empty-state,
        .pagination,
        .auth-card {
            background: #ffffff;
            border: 1px solid var(--line);
            box-shadow: none;
        }

        .topbar {
            border-radius: 16px;
            padding: 18px 22px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-bottom: 28px;
        }

        .brand {
            display: flex;
            align-items: center;
        }

        .brand h1,
        .page-title,
        .auth-title {
            margin: 0;
            font-family: Georgia, "Times New Roman", serif;
        }

        .brand p,
        .meta,
        .helper,
        .flash,
        .field-error,
        .pagination span {
            margin: 0;
            color: var(--muted);
        }

        .nav-links,
        .page-actions,
        .inline-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .nav-link,
        .button,
        .button-secondary,
        .button-ghost,
        .status-button {
            border: 0;
            border-radius: 999px;
            cursor: pointer;
            font: inherit;
            transition: background 0.18s ease, border-color 0.18s ease;
        }

        .nav-link,
        .button-secondary,
        .button-ghost {
            padding: 11px 16px;
            background: rgba(255, 255, 255, 0.78);
            color: var(--ink);
            border: 1px solid var(--line);
        }

        .button,
        .status-button {
            padding: 12px 18px;
            background: #0f766e;
            color: #f8fafc;
        }

        .button-secondary {
            background: #fff7ed;
            color: #9a3412;
        }

        .button:hover,
        .button-secondary:hover,
        .button-ghost:hover,
        .nav-link:hover,
        .status-button:hover {
            background-color: #f0f4f7;
        }

        .button:hover,
        .status-button:hover {
            background: #0b5b55;
        }

        .auth-card,
        .card,
        .empty-state,
        .pagination {
            border-radius: 16px;
            padding: 24px;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border-radius: 999px;
            padding: 6px 10px;
            font-size: 0.86rem;
            width: fit-content;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 20px;
        }

        .stat {
            border-radius: 14px;
            padding: 16px;
        }

        .stat strong {
            display: block;
            margin-top: 6px;
            font-size: 1.6rem;
            font-family: Georgia, "Times New Roman", serif;
        }

        .form-grid,
        .task-list,
        .auth-card {
            display: grid;
            gap: 16px;
        }

        .field {
            display: grid;
            gap: 8px;
        }

        label {
            font-weight: 700;
        }

        input,
        textarea,
        select {
            width: 100%;
            border: 1px solid var(--line);
            border-radius: 10px;
            padding: 13px 14px;
            font: inherit;
            color: var(--ink);
            background: rgba(255, 255, 255, 0.78);
        }

        textarea {
            min-height: 140px;
            resize: vertical;
        }

        .field-error {
            font-size: 0.92rem;
            color: var(--danger);
        }

        .task-card {
            border-radius: 14px;
            padding: 18px;
            display: grid;
            gap: 12px;
        }

        .task-header,
        .task-footer,
        .meta-row,
        .page-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        .task-title {
            margin: 0;
            font-size: 1.3rem;
            font-family: Georgia, "Times New Roman", serif;
        }

        .task-description {
            margin: 0;
            line-height: 1.6;
            color: #44515d;
        }

        .badge {
            font-weight: 700;
        }

        .badge-pending {
            color: #9a3412;
            background: rgba(251, 191, 36, 0.18);
        }

        .badge-completed {
            color: var(--success);
            background: rgba(34, 197, 94, 0.18);
        }

        .badge-overdue {
            color: #991b1b;
            background: rgba(239, 68, 68, 0.16);
        }

        .flash-wrap {
            display: grid;
            gap: 12px;
            margin-bottom: 20px;
        }

        .flash {
            border-radius: 12px;
            padding: 14px 16px;
            border: 1px solid var(--line);
            background: rgba(255, 255, 255, 0.78);
        }

        .flash-success {
            border-color: rgba(22, 101, 52, 0.16);
            color: var(--success);
        }

        .flash-error {
            border-color: rgba(185, 28, 28, 0.18);
            color: var(--danger);
        }

        .flash.hide {
            opacity: 0;
            transform: translateY(-6px);
            transition: opacity 0.24s ease, transform 0.24s ease;
        }

        .empty-state {
            text-align: center;
        }

        .page-title {
            font-size: clamp(1.8rem, 4vw, 2.3rem);
        }

        .helper {
            line-height: 1.6;
        }

        .auth-shell {
            max-width: 520px;
            margin: 0 auto;
            padding-top: 42px;
        }

        .auth-title {
            font-size: 2.2rem;
        }

        body.auth-simple {
            background: #f4f6f8;
        }

        body.auth-simple .shell {
            width: min(100% - 24px, 460px);
            padding-top: 56px;
        }

        body.auth-simple .auth-shell {
            max-width: none;
            padding-top: 0;
        }

        body.auth-simple .auth-card {
            background: #ffffff;
            border: 1px solid #d9e0e7;
            box-shadow: none;
            backdrop-filter: none;
            border-radius: 16px;
        }

        body.auth-simple .button {
            width: 100%;
            display: inline-flex;
            justify-content: center;
        }

        .pagination {
            margin-top: 18px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        @media (max-width: 940px) {
            .stats {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 640px) {
            .shell {
                width: min(100% - 20px, 1120px);
                padding-top: 14px;
            }

            .topbar,
            .card,
            .stat,
            .task-card,
            .empty-state,
            .pagination,
            .auth-card {
                padding: 18px;
            }
        }
    </style>
</head>
<body class="@yield('body_class')">
    <div class="shell">
        @unless (trim($__env->yieldContent('hide_topbar')))
            <div class="topbar">
                <div class="brand">
                    <div>
                        <h1>{{ $appBrand }}</h1>
                        <p>Personal task manager for focused daily execution.</p>
                    </div>
                </div>

                <div class="nav-links">
                    @auth
                        <a class="nav-link" href="{{ route('tasks.index') }}">My Tasks</a>
                        <a class="button-secondary" href="{{ route('tasks.create') }}">Add Task</a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="button-ghost" type="submit">Logout</button>
                        </form>
                    @else
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                        <a class="button" href="{{ route('register') }}">Create Account</a>
                    @endauth
                </div>
            </div>
        @endunless

        <div class="flash-wrap">
            @if (session('success'))
                <div class="flash flash-success" data-flash>{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="flash flash-error" data-flash>{{ $errors->first() }}</div>
            @endif
        </div>

        @yield('content')
    </div>

    <script>
        window.setTimeout(() => {
            document.querySelectorAll('[data-flash]').forEach((element) => {
                element.classList.add('hide');
            });
        }, 3200);
    </script>
</body>
</html>
