<div>
   <x-card cardTitle="Bienvenid@s" cardFooter=''>
      <x-slot:cardTools>
         @if (isAdmin())
            <a href="{{route('sales.list')}}" class="btn btn-primary">
               <i class="fas fa-shopping-cart"></i> Ir a ventas
            </a>           
         @endif

         <a href="{{route('sales.create')}}" class="btn bg-purple">
            <i class="fas fa-cart-plus"></i> Crear venta
         </a>
      </x-slot>

      {{-- row cards ventas hoy --}}

      @include('home.row-cards-sales')
      
      @if (isAdmin())
      {{-- Card grafica --}}

      @include('home.card-graph')

      {{-- Boxes reports --}}

      @include('home.boxes-reports')

      {{-- Tablas reportes productos --}}

      @include('home.tables-reports')

      {{-- Mejores vendedores y compradores --}}

      @include('home.best-sellers-buyers')

      @endif

   </x-card>

</div>
