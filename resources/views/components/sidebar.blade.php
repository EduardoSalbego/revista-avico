<link href="{{ asset('css/sidebar.css') }}" rel="stylesheet" type="text/css">
<script src="{{ asset('js/sidebar.js') }}" defer></script>

<div class="">
    <!-- It is quality rather than quantity that matters. - Lucius Annaeus Seneca -->
    <div class="d-flex align-items-stretch " style="height: 94vh; width: 190px; background-color:white; ">
        <ul class="list-group " style="width: 190px; border-radius: 0; ">
            @role('editor-chefe')
                @include('components.sidebar_lists.editor-chefe_list')
            @endrole
            @role('autor')
                @include('components.sidebar_lists.autor_list')
            @endrole
            @role('avaliador')
                @include('components.sidebar_lists.avaliador_list')
            @endrole
            @role('editor')
                @include('components.sidebar_lists.editor_list')
            @endrole
        </ul>
    </div>
</div>
