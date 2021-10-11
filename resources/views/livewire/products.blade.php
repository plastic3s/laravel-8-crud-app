<div>
    @include('livewire.create')
    @include('livewire.update')
{{--    <div class="form-group">--}}
{{--        <input type="search"  class="form-control" placeholder="Search" wire:model="searchTerm" />--}}
{{--    </div>--}}
    <div class="input-group">
        <input type="text" class="form-control" placeholder="Search" wire:model="searchTerm" >
        <div class="input-group-append">
            <button class="btn btn-secondary" type="button">
                <i class="fa fa-search"></i>
            </button>
        </div>
    </div>
    @if (session()->has('message'))
        <div class="alert alert-success" style="margin-top:30px;">x
            {{ session('message') }}
        </div>
    @endif
    <table class="table table-bordered mt-5">
        <thead>
        <tr>
            <th>No.</th>
            <th>Product Name </th>
            <th>Desc</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($products as $value)
            <tr>
                <td>{{ $value->id }}</td>
                <td>{{ $value->name }}</td>
                <td>{{ $value->desc }}</td>
                <td>
                    <button data-toggle="modal" data-target="#updateModal" wire:click="edit({{ $value->id }})" class="btn btn-primary btn-sm">Edit</button>
                    <button wire:click="delete({{ $value->id }})" class="btn btn-danger btn-sm">Delete</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
{{--    {{ $products->links() }}--}}
    {{ $products->links('livewire.livewire-pagination',['search' => $search]) }}
{{--    {{ $products->links('pagination::tailwind') }}--}}
{{--    {{ $products->links('pagination::custom') }}--}}
</div>
