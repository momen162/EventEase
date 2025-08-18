@extends('admin.layout')
@section('title','Pending Event Requests')

@section('content')
<div class="admin-requests"><!-- SCOPE WRAPPER -->
  <style>
    /* Page-scoped tokens (avoid :root to prevent leaks) */
    .admin-requests{
      --bg:#ffffff;
      --surface:#ffffff;
      --surface-2:#f9fafb;
      --text:#111827;
      --muted:#6b7280;
      --border:#e5e7eb;
      --ring: rgba(37,99,235,.35);

      --primary:#2563eb;
      --primary-600:#1d4ed8;
      --danger:#dc2626;

      --radius:14px;
      --shadow:0 10px 30px rgba(0,0,0,.06);
      --shadow-sm:0 2px 10px rgba(0,0,0,.05);
    }

    .admin-requests .ar-wrap{ padding: clamp(12px,1.8vw,20px); background: var(--bg); color: var(--text); }
    .admin-requests .ar-head{
      display:flex; align-items:flex-end; justify-content:space-between; gap: 12px; flex-wrap: wrap;
      margin-bottom: 12px;
    }
    .admin-requests .ar-title{ margin:0; font-weight:800; letter-spacing:.2px; }
    .admin-requests .ar-subtitle{ margin:0; color:var(--muted); }

    .admin-requests .ar-empty{
      border:1px dashed var(--border); border-radius:12px; background:var(--surface-2);
      padding:22px; color:var(--muted); text-align:center; box-shadow: var(--shadow-sm);
    }

    .admin-requests .ar-table-wrap{
      margin-top: 12px; border: 1px solid var(--border); border-radius: 12px; overflow: hidden;
      background: var(--surface);
      box-shadow: var(--shadow);
    }
    .admin-requests .ar-table{ width:100%; border-collapse: separate; border-spacing:0; font-size:.96rem; }
    .admin-requests .ar-table thead th{
      text-align:left; padding:12px 14px; background:#fff; border-bottom:1px solid var(--border);
      color:var(--muted); font-weight:800;
    }
    .admin-requests .ar-table tbody td{ padding:12px 14px; border-bottom:1px solid var(--border); vertical-align: top; }
    .admin-requests .ar-table tbody tr:nth-child(even){ background: var(--surface-2); }
    .admin-requests .ar-table tbody tr:hover{ background: #fff; }

    .admin-requests .ar-col-id{ width:72px; color:var(--muted); }
    .admin-requests .ar-col-actions{ width:260px; text-align:right; white-space: nowrap; }

    /* Pills / badges */
    .admin-requests .ar-chip{
      display:inline-flex; align-items:center; gap:6px; padding:6px 10px; border-radius:999px;
      font-weight:700; font-size:.85rem; border:1px solid;
    }
    .admin-requests .ar-chip-when{ background:#ecfeff; color:#155e75; border-color:#cffafe; }
    .admin-requests .ar-chip-loc{ background:#fef9c3; color:#854d0e; border-color:#fde68a; }
    .admin-requests .ar-chip-cap{ background:#eef2ff; color:#3730a3; border-color:#e0e7ff; }

    .admin-requests .ar-creator{ display:grid; gap:2px; }
    .admin-requests .ar-creator small{ color: var(--muted); }

    /* Buttons (scoped) */
    .admin-requests .ar-btn{
      appearance:none; border:1px solid var(--border); border-radius: 999px;
      padding: 10px 14px; font-weight:700; text-decoration:none; cursor:pointer;
      display:inline-flex; align-items:center; gap:.5rem; transition:.18s ease;
      background:#fff; color:var(--text); box-shadow: var(--shadow-sm);
    }
    .admin-requests .ar-btn:hover{ transform: translateY(-1px); box-shadow: var(--shadow); }
    .admin-requests .ar-btn:focus-visible{ outline:3px solid var(--ring); outline-offset:2px; }
    .admin-requests .ar-btn-primary{ background: var(--primary); color:#fff; border-color: transparent; }
    .admin-requests .ar-btn-primary:hover{ background: var(--primary-600); }
    .admin-requests .ar-btn-ghost{ background: var(--surface-2); }

    /* Icons */
    .admin-requests .ar-ico{ display:inline-flex; }

    /* Responsive stack */
    @media (max-width: 960px){
      .admin-requests .ar-table-wrap{ border-radius:10px; }
      .admin-requests .ar-table,
      .admin-requests .ar-table thead,
      .admin-requests .ar-table tbody,
      .admin-requests .ar-table th,
      .admin-requests .ar-table td,
      .admin-requests .ar-table tr{ display:block; }
      .admin-requests .ar-table thead{ display:none; }
      .admin-requests .ar-table tbody tr{ border-bottom:1px solid var(--border); padding:8px 12px; }
      .admin-requests .ar-table tbody td{
        border: none; padding:8px 0; display:grid; grid-template-columns: 130px 1fr; gap:8px;
      }
      .admin-requests .ar-table tbody td::before{
        content: attr(data-label);
        font-weight:700; color:var(--muted);
      }
      .admin-requests .ar-col-actions{ width:auto; text-align:left; }
    }
  </style>

  <div class="ar-wrap">
    <div class="ar-head">
      <div>
        <h2 class="ar-title">Pending Event Requests</h2>
        <p class="ar-subtitle">Review and approve or reject user-submitted event requests.</p>
      </div>
    </div>

    @if($rows->isEmpty())
      <div class="ar-empty">No pending requests.</div>
    @else
      <div class="ar-table-wrap" role="region" aria-label="Pending requests table">
        <table class="ar-table">
          <thead>
            <tr>
              <th class="ar-col-id">ID</th>
              <th>Title</th>
              <th>When</th>
              <th>Location</th>
              <th>Capacity</th>
              <th>Requested By</th>
              <th class="ar-col-actions">Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($rows as $r)
              <tr>
                <td class="ar-col-id" data-label="ID">#{{ $r->id }}</td>
                <td data-label="Title"><strong>{{ $r->title }}</strong></td>
                <td data-label="When">
                  <span class="ar-chip ar-chip-when">
                    <svg class="ar-ico" width="14" height="14" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                      <path d="M7 2v4M17 2v4M3 9h18M5 21h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5A2 2 0 0 0 3 7v12a2 2 0 0 0 2 2Z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                    </svg>
                    {{ \Carbon\Carbon::parse($r->starts_at)->format('M d, Y H:i') }}
                    @if($r->ends_at)
                      – {{ \Carbon\Carbon::parse($r->ends_at)->format('M d, Y H:i') }}
                    @endif
                  </span>
                </td>
                <td data-label="Location">
                  @php $loc = $r->location ?? '—'; @endphp
                  <span class="ar-chip ar-chip-loc">
                    <svg class="ar-ico" width="14" height="14" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                      <path d="M12 21s7-4.35 7-11a7 7 0 0 0-14 0c0 6.65 7 11 7 11Z" stroke="currentColor" stroke-width="1.6"/>
                      <circle cx="12" cy="10" r="2.5" stroke="currentColor" stroke-width="1.6"/>
                    </svg>
                    {{ $loc }}
                  </span>
                </td>
                <td data-label="Capacity">
                  <span class="ar-chip ar-chip-cap">
                    <svg class="ar-ico" width="14" height="14" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                      <path d="M4 7h16M5 20h14a1 1 0 0 0 1-1v-8H4v8a1 1 0 0 0 1 1Z" stroke="currentColor" stroke-width="1.6"/>
                    </svg>
                    {{ $r->capacity ?? '—' }}
                  </span>
                </td>
                <td data-label="Requested By">
                  <div class="ar-creator">
                    <strong>{{ optional($r->creator)->name ?? 'Unknown' }}</strong>
                    <small>{{ optional($r->creator)->email ?? '' }}</small>
                  </div>
                </td>
                <td class="ar-col-actions" data-label="Actions">
                  <form action="{{ route('admin.requests.approve', $r) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="ar-btn ar-btn-primary">Approve</button>
                  </form>
                  <form action="{{ route('admin.requests.reject', $r) }}" method="POST" style="display:inline;" onsubmit="return confirm('Reject this request?');">
                    @csrf
                    <button type="submit" class="ar-btn ar-btn-ghost">Reject</button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @endif
  </div>
</div>
@endsection
