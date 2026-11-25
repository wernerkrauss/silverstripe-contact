<main class="mx-auto my-16 w-full max-w-5xl grow px-6">
    <h1 class="mb-8 text-center text-3xl font-bold text-primary-500">$Title</h1>
    
    <section class="prose max-w-none lg:prose-xl mb-12">
        $Content
    </section>

    <div class="rounded-[3rem] bg-primary-500 px-6 py-10 md:px-10 md:py-12 shadow-xl">
        <div hx-get="$Link('renderForm')" hx-trigger="load" hx-swap="outerHTML">
            <div class="flex justify-center p-8">
                <svg class="animate-spin h-8 w-8 text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
        </div>
    </div>
</main>
