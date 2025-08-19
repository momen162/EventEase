@extends('admin.layout')
@section('title','Pending Event Requests')
@section('content')
<div class="max-w-7xl mx-auto p-4 sm:p-6">
  <div class="mb-6 flex items-center justify-between gap-3">
    <div>
      <h2 class="text-2xl font-semibold tracking-tight flex items-center gap-2">
        <span>Pending Event Requests</span>
        <span class="badge badge-primary badge-sm align-middle">{{ $rows->count() }}</span>
      </h2>
      <p class="text-sm opacity-70 mt-1">Review, approve, or reject event submissions.</p>
    </div>
  </div>

  @if($rows->isEmpty())
    <div class="alert alert-info shadow-sm">
      <span>No pending requests.</span>
    </div>
  @else
    <div class="card bg-base-100 shadow-sm border border-base-200">
      <div class="card-body p-0">
        <div class="overflow-x-auto">
          <table class="table table-zebra w-full">
            <thead class="bg-base-200/60">
              <tr>
                <th class="whitespace-nowrap">ID</th>
                <th class="min-w-[200px]">Title</th>
                <th class="min-w-[240px]">When</th>
                <th class="min-w-[160px]">Location</th>
                <th class="whitespace-nowrap">Capacity</th>
                <th class="min-w-[220px]">Requested By</th>
                <th class="whitespace-nowrap text-right">Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($rows as $r)
                <tr class="hover">
                  <td class="align-top">#{{ $r->id }}</td>

                  <td class="align-top">
                    <div class="font-medium">{{ $r->title }}</div>
                    @if(!empty($r->description))
                      <div class="text-xs opacity-70 line-clamp-2">{{ Str::limit(strip_tags($r->description), 120) }}</div>
                    @endif
                  </td>

                  <td class="align-top">
                    <div class="flex flex-col">
                      <time datetime="{{ $r->starts_at }}" class="font-medium">
                        {{ \Carbon\Carbon::parse($r->starts_at)->format('M d, Y H:i') }}
                      </time>
                      @if($r->ends_at)
                        <span class="opacity-70">
                          – {{ \Carbon\Carbon::parse($r->ends_at)->format('M d, Y H:i') }}
                        </span>
                      @endif
                    </div>
                  </td>

                  <td class="align-top">
                    @php $loc = $r->location ?? '—'; @endphp
                    <span class="badge badge-ghost">{{ $loc }}</span>
                  </td>

                  <td class="align-top">
                    @php $cap = $r->capacity ?? '—'; @endphp
                    <span class="badge">{{ $cap }}</span>
                  </td>

                  <td class="align-top">
                    <div class="font-medium">{{ optional($r->creator)->name ?? 'Unknown' }}</div>
                    <div class="text-xs opacity-70">{{ optional($r->creator)->email ?? '' }}</div>
                  </td>

                  <td class="align-top">
                    <div class="flex justify-end gap-2">
                      <form action="{{ route('admin.requests.approve', $r) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-sm">Approve</button>
                      </form>
                      <form action="{{ route('admin.requests.reject', $r) }}" method="POST" class="inline" onsubmit="return confirm('Reject this request?');">
                        @csrf
                        <button type="submit" class="btn btn-ghost btn-sm">Reject</button>
                      </form>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  @endif
</div>
@endsection
