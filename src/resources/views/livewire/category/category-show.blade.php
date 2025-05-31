<x-card cardTitle="Detalles categoria">
    <x-slot:cardTools>
       <a href="{{route('categories')}}" class="btn btn-primary">
        <i class="fas fa-arrow-circle-left"></i> Regresar
       </a>
    </x-slot>
    
    <div class="row">
        <div class="col-md-4">

            <div class="card card-primary card-outline">
                <div class="card-body box-profile">

                    <h2 class="profile-username text-center mb-2">{{$category->name}}</h2>
                
                    <ul class="list-group mb-3">
                        <li class="list-group-item">
                            <b>Productos</b> <a class="float-right">{{count($category->products)}}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Articulos</b> 
                            <a class="float-right">
                                {{$products->sum('stock')}}
                            </a>
                        </li>

                    </ul>
                    
                </div>
            
            </div>
            
        </div>
        <div class="col-md-8">
            <table class="table text-center">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Imagen</th>
                        <th>Producto</th>
                        <th>Precio venta</th>
                        <th>Stock</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                    <tr>
                        <td>{{$product->id}}</td>
                        <td>
                            <x-image :item="$product" />
                        </td>
                        <td>{{$product->name}}</td>
                        <td>{!! $product->precio !!}</td>
                        <td>{!! $product->stockLabel !!}</td>
                    </tr>                        
                    @endforeach

                    
                </tbody>
            </table>
            {{$products->links()}}
        </div>    
    </div>

 </x-card>