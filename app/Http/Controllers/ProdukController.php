<?php

namespace App\Http\Controllers;

use App\Http\Requests\Produk\StoreRequest;
use App\Http\Requests\Produk\UpdateRequest;
use App\Http\Requests\SearchRequest;
use App\Models\produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SearchRequest $request)
    {
        $this->authorize('viewAny', Produk::class);

        $keyword = $request->input('search');

        if($keyword) {
            $products = Produk::when($keyword, function ($query) use ($keyword) {
                $query->where('nama', 'like', '%'.$keyword.'%');
            })
            ->orderBy('nama')
            ->paginate(10)
            ->withQueryString();
        } else {
            $products = Produk::latest()->paginate(10)->withQueryString();
        }

        return view('produk.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Produk::class);

        return view('produk.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $this->authorize('create', Produk::class);

       $data = $request->validated();

       $data['user_id'] = Auth()->id();
       $data['nama'] = $data['name'];
       $data['harga_beli'] = $data['purchase_price'];
       $data['harga_jual'] = $data['selling_price'];
       $data['stok'] = $data['stok'] ?? true;

       if ($request->hasFile('foto')) {
          $data['foto'] = $request->file('foto')->store('products', 'public');
        }

        Produk::create($data);

         return redirect()->route('produk.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produk $produk)
    {
        $this->authorize('update', $Produk);

        return view('produk.edit', compact('produk'));
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(UpdateRequest $request, Produk $produk)
{
    $this->authorize('update', $Produk);

    $data = $request->validated();

    $data = [
        'user_id'    => Auth::id(),
        'nama'       => $data['name'],
        'harga_beli' => $data['purchase_price'],
        'harga_jual' => $data['selling_price'],
        'stok'       => $data['stock'],
    ];

    // jika upload foto baru
    if ($request->hasFile('foto')) {

        // hapus foto lama (jika ada & memang tersimpan)
        if ($produk->foto && 
            Storage::disk('public')->exists($produk->foto)) {
            Storage::disk('public')->delete($produk->foto);
        }

        // simpan foto baru
        $data['foto'] = $request->file('foto')->store('products', 'public');
    }

    $produk->update($data);

    return redirect()->route('produk.index')->with('success', 'Product updated successfully.');
  }

  /**
 * Remove the specified resource from storage.
 */
public function destroy(Produk $produk)
{
    $this->authorize('delete', $Produk);

    if ($produk->foto){
        Storage::disk('public')->delete($produk->foto);
    }

    $produk->delete();
    return redirect()->route('produk.index')->with('success', 'Product deleted successfully.');
  }
}