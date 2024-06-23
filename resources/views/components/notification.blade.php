<div
    x-data="{ show: false, message: '', color: null}"
    x-on:notify.window="setTimeout(() => { show = true }, 200); show = true; message = $event.detail[0].text; color = $event.detail[0].color; setTimeout(() => { show = false }, 3000)"
    x-show="show"
    x-transition:enter.duration.100ms
    x-transition:leave.duration.800ms
    class="border-gray-300 border fixed top-5 right-5 z-50 flex items-center max-w-xs p-4  rounded-lg shadow-lg  text-gray-800 bg-white " role="alert" style="display:none">
    <div class="alert alert-success" role="alert" x-text="message">

</div>

</div>
