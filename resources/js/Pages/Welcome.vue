<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});
</script>

<template>
    <Head title="Sistema de Produtos" />

    <div class="min-h-screen bg-slate-950 text-white">

        <!-- NAVBAR -->
        <header class="border-b border-white/10">
            <div class="mx-auto flex max-w-5xl items-center justify-between px-6 py-5">

                <div class="flex items-center gap-3">
                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-600 font-bold"
                    >
                        SP
                    </div>

                    <span class="font-bold">
                        Sistema de Produtos
                    </span>
                </div>

                <div class="flex gap-3">
                    <Link
                        v-if="canLogin"
                        :href="route('login')"
                        class="rounded-lg px-4 py-2 text-sm text-slate-300 hover:bg-white/10 hover:text-white"
                    >
                        Entrar
                    </Link>

                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold hover:bg-blue-500"
                    >
                        Criar conta
                    </Link>
                </div>

            </div>
        </header>


        <!-- CONTEÚDO -->
        <main class="flex min-h-[calc(100vh-81px)] items-center justify-center px-6">

            <div class="w-full max-w-2xl text-center">

                <div
                    class="mx-auto mb-6 w-fit rounded-full border border-blue-500/20 bg-blue-500/10 px-4 py-2 text-sm text-blue-300"
                >
                    Sistema de gerenciamento
                </div>

            

                <p class="mx-auto mt-6 max-w-xl text-lg text-slate-400">
                    Sistema desenvolvido para gerenciamento de produtos,
                    usuários e níveis de acesso.
                </p>

                <div class="mt-8 flex justify-center gap-4">

                    <Link
                        v-if="canLogin"
                        :href="route('login')"
                        class="rounded-xl bg-blue-600 px-6 py-3 font-semibold shadow-lg shadow-blue-600/20 transition hover:-translate-y-0.5 hover:bg-blue-500"
                    >
                        Entrar
                    </Link>

                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="rounded-xl border border-white/10 bg-white/5 px-6 py-3 font-semibold transition hover:bg-white/10"
                    >
                        Criar conta
                    </Link>

                </div>

                <p class="mt-10 text-sm text-slate-600">
                    Laravel • Vue.js • PostgreSQL
                </p>

            </div>

        </main>

    </div>
</template>
