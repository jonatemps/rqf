<center>
    {{-- <h1 style="color: green">GeeksforGeeks</h1>
    <h3>Embedding the PDF file Using Object Tag</h3> --}}
    {{-- <object data=
"https://media.geeksforgeeks.org/wp-content/cdn-uploads/20210101201653/PDF.pdf"
            width="550"
            height="500">
    </object> --}}

    <object
        class="pdf"
        data="{{$path}}"
        width="350"
        height="500">
    </object>
</center>
