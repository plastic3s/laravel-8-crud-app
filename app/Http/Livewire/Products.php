<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Pagination\Paginator;

class Products extends Component
{
    use WithPagination;

//    public $products;
    public $name, $desc, $product_id;
    public $updateMode = false;

    public $searchTerm;
    public $currentPage = 1;

//    protected $paginationTheme = 'bootstrap';

    public function render()
    {
//        $query = '%'.$this->searchTerm.'%';

        return view('livewire.products',[
                'products' => Product::where(function($sub_query){
                    $sub_query->where('name', 'like', '%'.$this->searchTerm.'%')
                        ->orWhere('desc', 'like', '%'.$this->searchTerm.'%');
                })->paginate(5),
                'search' => $this->searchTerm
        ]);
    }

    public function setPage($url)
    {
        $this->currentPage = explode('page=', $url)[1];
        Paginator::currentPageResolver(function(){
            return $this->currentPage;
        });
    }

    private function resetInputFields(){
        $this->name = '';
        $this->desc = '';
    }

    public function store()
    {
        $validatedDate = $this->validate([
            'name' => 'required',
            'desc' => 'required',
        ]);

        Product::create($validatedDate);

        session()->flash('message', 'Products Created Successfully.');

        $this->resetInputFields();

        $this->emit('productStore'); // Close model to using to jquery

    }

    public function edit($id)
    {
        $this->updateMode = true;
        $product = Product::where('id',$id)->first();
        $this->product_id = $id;
        $this->name = $product->name;
        $this->desc = $product->desc;

    }

    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();


    }

    public function update()
    {
        $validatedDate = $this->validate([
            'name' => 'required',
            'desc' => 'required',
        ]);

        if ($this->product_id) {
            $product = Product::find($this->product_id);
            $product->update([
                'name' => $this->name,
                'desc' => $this->desc,
            ]);
            $this->updateMode = false;
            session()->flash('message', 'Products Updated Successfully.');
            $this->resetInputFields();

        }
    }

    public function delete($id)
    {
        if($id){
            Product::where('id',$id)->delete();
            session()->flash('message', 'Products Deleted Successfully.');
        }
    }
}
