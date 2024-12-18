@extends('layouts.main')

@section('content')
    <main class="w-full">
        <div class="grid sm:grid-cols-1 items-center justify-center gap-16 p-4 mx-auto max-w-4xl font-[sans-serif] mt-12">
            <div class="flex flex-col justify-center items-center">
                <h1 class="text-gray-800 text-3xl font-extrabold">Let's Talk</h1>
                <p class="text-2xl text-center dark:text-gray-50 text-gray-800 mt-4">Have some big idea or brand to develop
                    and need help? Then reach out
                    we'd love to hear about your project and provide help.</p>

                <div class="flex flex-col">
                    <div class="mt-8">
                        <h2 class="text-gray-800 text-base font-bold">For business inquiries contact</h2>
                        <ul class="mt-4">
                            <li class="flex items-center">
                                <div
                                    class="bg-[#e6e6e6cf] h-10 w-10 rounded-full flex items-center justify-center shrink-0">
                                    <i class="fa fa-envelope text-blue-500"></i>
                                </div>
                                <a href="mailto::contact@doombringerz.com" class="text-[#007bff] text-sm ml-4">
                                    <strong>contact@doombringerz.com</strong>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="mt-8">
                        <h2 class="text-gray-800 text-base font-bold">or issues with your merchandise order contact</h2>
                        <ul class="mt-4">
                            <li class="flex items-center">
                                <div
                                    class="bg-[#e6e6e6cf] h-10 w-10 rounded-full flex items-center justify-center shrink-0">
                                    <i class="fa fa-envelope text-blue-500"></i>
                                </div>
                                <a href="mailto::merchsupport@doombringerz.com" class="text-[#007bff] text-sm ml-4">
                                    <strong>merchsupport@doombringerz.com</strong>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="mt-8">
                        <h2 class="text-gray-800 text-base font-bold">For issues regarding any of the hosted servers use the ticket system in our community in:</h2>
                        <ul class="mt-4">
                            <li class="flex items-center">
                                <div
                                    class="bg-[#e6e6e6cf] h-10 w-10 rounded-full flex items-center justify-center shrink-0">
                                    <i class="fab fa-discord text-blue-500"></i>
                                </div>
                                <a href="https://discord.gg/QmrmHpEmnm" class="text-[#007bff] text-sm ml-4">
                                    <strong>info@example.com</strong>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
