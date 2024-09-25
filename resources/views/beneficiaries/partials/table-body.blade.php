@foreach ($beneficiaries as $beneficiary)
    <tr>
        <th scope="row">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="chk_child" value="{{ $beneficiary->id }}">
            </div>
        </th>
        <td class="beneficiary_id" style="display:none;">{{ $beneficiary->id }}</td>
        <td class="beneficiary_name">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <img src="{{ $beneficiary->image_path ? asset($beneficiary->image_path) : 'https://via.placeholder.com/128?text=No+Image' }}"
                        alt="" class="avatar-xxs rounded-circle image_src object-fit-cover">
                </div>
                <div class="flex-grow-1 ms-2 name">
                    {{ ucfirst(strtolower($beneficiary->last_name)) }},
                    {{ ucfirst(strtolower($beneficiary->first_name)) }}
                    {{ substr($beneficiary->middle_name, 0, 1) . '.' }}
                </div>
            </div>
        </td>
        <td class="barangay_name">{{ $beneficiary->barangay->name }}, {{ $beneficiary->barangay->municity->name }}, {{ $beneficiary->barangay->municity->province->name }}</td>
        <td class="asenso_id">{{ $beneficiary->asenso_id }}</td>
        <td class="sex">{{ $beneficiary->sex }}</td>
        <td class="birth_date">{{ $beneficiary->birth_date }}</td>
        <td class="status">
            <span class="badge {{ $beneficiary->status == 1 ? 'bg-success' : 'bg-danger' }}">
                {{ $beneficiary->status == 1 ? 'Active' : 'Inactive' }}
            </span>
        </td>
        <td>
            <ul class="list-inline hstack gap-2 mb-0">
                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">
                    <a href="{{ route('beneficiaries.show', $beneficiary->id) }}">
                        <i class="ri-eye-fill align-bottom text-muted"></i>
                    </a>
                </li>
            </ul>
        </td>
    </tr>
@endforeach
