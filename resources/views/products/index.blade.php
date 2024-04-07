<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <a type="button" href="{{route('products.create')}}" class="bg-indigo-500 px-12 py-4  rounded text-gray-200 font-semibold hover:bg-indigo-800 transition duration-200 ease-in-out ">Crear</a>
                <table class="table-fixed w-full mt-3">
                    <thead>
                        <tr class="bg-gray-800 text-white">
                            <th>ID</th>
                            <th class="border px-4 py-2">NOMBRE</th>
                            <th class="border px-4 py-2">DESCRIPCION</th>
                            <th class="border px-4 py-1">IMAGEN</th>
                            <th>ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>{{$product->name}}</td>
                            <td>{{$product->description}}</td>
                            <td class="border px-4 py-1">
                                <img src="{{$product->image}}" alt="Celular{{$product->name}}" width="60%">    
                            </td>
                            <td class="border px-4 py-2">
                                <div class="flex justify-center rounded-lg text-lg" role="group">
                                    <a href="{{route(products.edit, $product->id)}}" class="rounded bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4">Editar</a>
                                    <form action="{{route('products.destroy', $product->id)}}" method="POST" class="formDelete rounded bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4">Eliminar>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="">
                    {!! $products->links() !!}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
(function(){
    'use strict';
    //debemos crear la clase formDelete dentro del form del boton borrar
    //recordar que cada registro a eliminar esta contenido en un form
    var forms = document.queryselectorAll('.formDelete');
    Array.prototype.slice.call(forms)
        .forEach(function(form){
            form.addEventListener('submit', function (event){
                event.preventDefault();
                event.stopPropagation();
                Swal.fire({
                    title: '¿Confirma la eliminación del registro?',
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#20c997',
                    cancelButtonColor: '#20c997',
                    confirmButtonText: 'Confirmar',
                }).then((result) => {
                    if (result.isConfirmed){
                        this.submit();
                        Swal.fire('¡Eliminado!', 'El registro ah sido eliminado exitosamente');
                    }
                })
            }, false)
        })
})()
</script>
