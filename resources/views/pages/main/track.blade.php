@extends('layouts.main')

@section('content')
    <main class="w-full">
        <div class="flex flex-col items-center justify-center mt-24">
            <div class="flex flex-col md:flex-row w-full justify-center items-center gap-4">
                <input type="text" class="px-4 py-4 rounded-lg w-11/12 md:w-8/12 lg:w-6/12 bg-gray-100 !border-2 !border-gray-500" placeholder="Enter tracking code" id="YQNum">
                <button class="bg-blue-500 px-4 py-4 rounded-lg" onclick="doTrack()">Track</button>
            </div>

            <div id="YQContainer" class="w-8/12 h-[600px] mt-12 rounded-lg overflow-hidden"></div>
        </div>
    </main>

    @push('scripts')
        <script type="text/javascript" src="//www.17track.net/externalcall.js"></script>

        <script type="text/javascript">
            function doTrack() {
                var num = document.getElementById("YQNum").value;
                if (num === "") {
                    alert("Enter your number.");
                    return;
                }
                YQV5.trackSingle({
                    //Required, Specify the container ID of the carrier content.
                    YQ_ContainerId: "YQContainer",
                    //Optional, specify tracking result height, max height 800px, default is 560px.
                    YQ_Height: 560,
                    //Optional, select carrier, default to auto identify.
                    YQ_Fc: "0",
                    //Optional, specify UI language, default language is automatically detected based on the browser settings.
                    YQ_Lang: "en",
                    //Required, specify the number needed to be tracked.
                    YQ_Num: num
                });
            }
        </script>
    @endpush
@endsection
