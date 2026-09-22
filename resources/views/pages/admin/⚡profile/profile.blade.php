
<div class="profile-shell">
    <div class="profile-header">
        <div>
            <p class="eyebrow">Account</p>
            <h1>Super Admin Profile</h1>
        </div>
        <a href="{{ route('admin.update_profile') }}" class="primary-btn">Edit profile</a>
    </div>

    <div class="profile-card">
        <div class="profile-avatar">{{ strtoupper(substr($profile['name'], 0, 1)) }}</div>
        <div class="profile-main">
            <div class="profile-title-row">
                <h2>{{ $profile['name'] }}</h2>
                <span class="role-pill">{{ $profile['role'] }}</span>
            </div>
            <p class="status-line"><span class="status-dot"></span> {{ $profile['status'] }}</p>
            <p class="profile-access">{{ $profile['access'] }}</p>
        </div>
    </div>

    <div class="info-grid">
        <div class="info-card">
            <p class="label">Email</p>
            <strong>{{ $profile['email'] }}</strong>
        </div>
        <div class="info-card">
            <p class="label">Phone</p>
            <strong>{{ $profile['phone'] }}</strong>
        </div>
        <div class="info-card">
            <p class="label">Location</p>
            <strong>{{ $profile['location'] }}</strong>
        </div>
        <div class="info-card">
            <p class="label">Access level</p>
            <strong>Full platform control</strong>
        </div>
    </div>
</div>

<style>
    .profile-shell {
        padding: 32px;
        background: #f5f7fb;
        min-height: 100vh;
        font-family: Arial, Helvetica, sans-serif;
        color: #111827;
    }

    .profile-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        margin-bottom: 26px;
    }

    .eyebrow {
        margin: 0 0 8px;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #6b7280;
        font-size: 11px;
        font-weight: 700;
    }

    h1, h2, p { margin: 0; }
    h1 { font-size: clamp(1.9rem, 2vw, 2.7rem); }

    .primary-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.8rem 1.1rem;
        border-radius: 12px;
        background: linear-gradient(135deg, #ff7b2c, #ff9f43);
        color: white;
        text-decoration: none;
        font-weight: 700;
    }

    .profile-card {
        display: flex;
        align-items: center;
        gap: 20px;
        padding: 22px;
        background: #fff;
        border: 1px solid #edf0f5;
        border-radius: 18px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.04);
        margin-bottom: 22px;
    }

    .profile-avatar {
        width: 76px;
        height: 76px;
        border-radius: 50%;
        background: linear-gradient(135deg, #111827, #ff7b2c);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: 800;
    }

    .profile-main {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .profile-title-row {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .role-pill {
        display: inline-flex;
        padding: 0.45rem 0.75rem;
        border-radius: 999px;
        background: #fff3e8;
        color: #c75d00;
        font-size: 0.75rem;
        font-weight: 700;
    }

    .status-line {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #1f9d67;
        font-weight: 700;
    }

    .status-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #1f9d67;
        display: inline-block;
    }

    .profile-access {
        color: #4b5563;
        max-width: 580px;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 18px;
    }

    .info-card {
        padding: 22px 18px;
        background: #fff;
        border: 1px solid #edf0f5;
        border-radius: 16px;
    }

    .label {
        color: #6b7280;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        margin-bottom: 10px;
    }

    @media (max-width: 820px) {
        .profile-shell {
            padding: 20px;
        }

        .profile-header,
        .info-grid {
            grid-template-columns: 1fr;
            display: grid;
        }

        .profile-card {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>