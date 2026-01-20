@extends('layouts.admin.main')

@section('title', 'Users')

@push('styles')
<style>
    .userEmail {
        word-break: break-all;
    }
</style>
@endpush

@section('content')

<div class="container py-4">

    <div class="d-flex align-items-center justify-content-between mb-1">

        <div class="d-flex align-items-start">
            <h1>Users</h1>
            <span class="badge text-success">{{ $users->total() }}</span>
        </div>


        <!-- Search and Sort Section -->
        <div class="row g-3">
            <div class="col-md-6">
                <form method="GET" action="{{ route('admin.users') }}" class="d-flex gap-2">
                    <input type="text" name="search" class="form-control rounded-0" placeholder="Search users by name or email..." value="{{ $search ?? '' }}">
                    <input type="hidden" name="sort" value="{{ $sort ?? 'name_asc' }}">
                    <button type="submit" class="btn btn-dark rounded-0">Search</button>
                    @if($search)
                    <a href="{{ route('admin.users') }}" class="btn btn-secondary rounded-0">Clear</a>
                    @endif
                </form>
            </div>

            <div class="col-md-6">
                <form method="GET" action="{{ route('admin.users') }}" class="d-flex gap-2">
                    <select name="sort" class="form-select rounded-0" onchange="this.form.submit()">
                        <option value="name_asc" {{ ($sort ?? 'name_asc') === 'name_asc' ? 'selected' : '' }}>Sort: Name (A-Z)</option>
                        <option value="name_desc" {{ ($sort ?? '') === 'name_desc' ? 'selected' : '' }}>Sort: Name (Z-A)</option>
                        <option value="email_asc" {{ ($sort ?? '') === 'email_asc' ? 'selected' : '' }}>Sort: Email (A-Z)</option>
                        <option value="email_desc" {{ ($sort ?? '') === 'email_desc' ? 'selected' : '' }}>Sort: Email (Z-A)</option>
                        <option value="role_asc" {{ ($sort ?? '') === 'role_asc' ? 'selected' : '' }}>Sort: Role (A-Z)</option>
                        <option value="role_desc" {{ ($sort ?? '') === 'role_desc' ? 'selected' : '' }}>Sort: Role (Z-A)</option>
                        <option value="newest" {{ ($sort ?? '') === 'newest' ? 'selected' : '' }}>Sort: Newest First</option>
                        <option value="oldest" {{ ($sort ?? '') === 'oldest' ? 'selected' : '' }}>Sort: Oldest First</option>
                    </select>
                    <input type="hidden" name="search" value="{{ $search ?? '' }}">
                </form>
            </div>
        </div>
    </div>


    <!-- View User Modal -->
    <div class="modal fade" id="viewUserModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">View User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label"><strong>Name</strong></label>
                        <p id="viewUserName" class="form-control-plaintext"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Email</strong></label>
                        <p id="viewUserEmail" class="form-control-plaintext"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Role</strong></label>
                        <p id="viewUserRole" class="form-control-plaintext"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('users.update') }}">
                        @csrf
                        <input type="hidden" id="editUserId" name="user_id">

                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" id="editUserName" name="name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" id="editUserEmail" name="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select id="editUserRole" name="role" class="form-control" required>
                                <option value="">Select Role</option>
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-warning">
                            Update User
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete User Modal -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete <strong id="deleteUserName"></strong>?</p>
                    <p class="text-danger">This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteUserForm" method="POST" style="display: inline;">
                        @csrf
                        <input type="hidden" id="deleteUserId" name="user_id">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <table class="table table-hover table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Role</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>

            @forelse($users as $user)
            <tr>
                <td>{{$user->name}}</td>
                <td class="userEmail">{{$user->email}}</td>
                <td>{{$user->role}}</td>
                <td>
                    <button type="button" class="btn rounded-0 btn-sm view-user-btn" data-bs-toggle="modal" data-bs-target="#viewUserModal"
                        data-id="{{ $user->id }}"
                        data-name="{{ $user->name }}"
                        data-email="{{ $user->email }}"
                        data-role="{{ $user->role }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
                            <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" />
                        </svg>
                    </button>
                    <button type="button" class="btn rounded-0 btn-sm edit-user-btn" data-bs-toggle="modal" data-bs-target="#editUserModal"
                        data-id="{{ $user->id }}"
                        data-name="{{ $user->name }}"
                        data-email="{{ $user->email }}"
                        data-role="{{ $user->role }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen-fill" viewBox="0 0 16 16">
                            <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001" />
                        </svg>
                    </button>
                    <button type="button" class="btn rounded-0 btn-sm delete-user-btn" data-bs-toggle="modal" data-bs-target="#deleteUserModal"
                        data-id="{{ $user->id }}"
                        data-name="{{ $user->name }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5" />
                        </svg>
                    </button>
                </td>
                @empty
                <div class="text-center">
                    <h3>No User Found.</h3>
                </div>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="mt-4 ms-auto">
        <nav>
            {{ $users->appends(request()->query())->links('pagination::bootstrap-5') }}
        </nav>
    </div>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // View User Button Handler
        document.querySelectorAll('.view-user-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const email = this.getAttribute('data-email');
                const role = this.getAttribute('data-role');

                viewUser(id, name, email, role);
            });
        });

        // Edit User Button Handler
        document.querySelectorAll('.edit-user-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const email = this.getAttribute('data-email');
                const role = this.getAttribute('data-role');

                editUser(id, name, email, role);
            });
        });

        // Delete User Button Handler
        document.querySelectorAll('.delete-user-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');

                deleteUser(id, name);
            });
        });
    });

    function viewUser(id, name, email, role) {
        document.getElementById('viewUserName').textContent = name;
        document.getElementById('viewUserEmail').textContent = email;
        document.getElementById('viewUserRole').textContent = role.charAt(0).toUpperCase() + role.slice(1);
    }

    function editUser(id, name, email, role) {
        document.getElementById('editUserId').value = id;
        document.getElementById('editUserName').value = name;
        document.getElementById('editUserEmail').value = email;
        document.getElementById('editUserRole').value = role;
    }

    function deleteUser(id, name) {
        document.getElementById('deleteUserId').value = id;
        document.getElementById('deleteUserName').textContent = name;
        document.getElementById('deleteUserForm').action = "{{ route('users.delete') }}";
    }
</script>
@endpush