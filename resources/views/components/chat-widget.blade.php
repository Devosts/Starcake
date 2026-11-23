@props([
    'channel',
    'myRole' => 'user',
    'sendUrl',
    'readUrl' => null,
    'seed' => [],
    'title' => 'Live Chat',
    'hint' => 'Tulis pesanmu — tim Star Cake akan membalas secepatnya.',
])

<div id="chat"
    x-data="chatWidget(@js($seed), @js($myRole), @js($sendUrl), @js($readUrl), @js($channel))"
    class="chat-panel">

    <div class="chat-head">
        <div class="flex min-w-0 items-center gap-2.5">
            <span class="chat-dot" :class="connected ? 'chat-dot-on' : 'chat-dot-off'"></span>
            <span class="truncate font-display text-base font-semibold text-ink">{{ $title }}</span>
        </div>
        <span class="shrink-0 text-label uppercase tracking-[0.12em] text-ink-40"
            x-text="connected ? 'Terhubung' : 'Menghubungkan…'"></span>
    </div>

    <div class="chat-body" x-ref="body">
        <template x-if="messages.length === 0">
            <p class="chat-empty">{{ $hint }}</p>
        </template>

        <template x-for="m in messages" :key="m.id">
            <div class="chat-row" :class="m.sender_role === myRole ? 'chat-row-me' : 'chat-row-them'">
                <div class="chat-bubble" :class="m.sender_role === myRole ? 'chat-bubble-me' : 'chat-bubble-them'">
                    <p class="chat-text" x-text="m.body"></p>
                    <span class="chat-time" x-text="m.created_at_label"></span>
                </div>
            </div>
        </template>
    </div>

    <form @submit.prevent="send()" class="chat-form">
        <textarea x-model="body" @keydown.enter.prevent="send()" rows="1" maxlength="2000"
            placeholder="Tulis pesan…" class="chat-input"></textarea>
        <button type="submit" class="chat-send" :disabled="sending || body.trim() === ''" aria-label="Kirim">
            <x-icon name="send" class="h-4 w-4" />
        </button>
    </form>
</div>

@push('scripts')
    <script>
        function chatWidget(seed, myRole, sendUrl, readUrl, channel) {
            return {
                messages: Array.isArray(seed) ? seed : [],
                myRole: myRole,
                sendUrl: sendUrl,
                readUrl: readUrl,
                channel: channel,
                body: '',
                sending: false,
                connected: false,

                init() {
                    this.$nextTick(() => this.scroll());
                    this.markRead();

                    if (window.Echo) {
                        window.Echo.private(this.channel)
                            .subscribed(() => { this.connected = true; })
                            .listen('.message.sent', (e) => {
                                this.append(e);
                                if (e.sender_role !== this.myRole) {
                                    this.markRead();
                                }
                            });
                    }
                },

                append(message) {
                    if (!message || this.messages.some((m) => m.id === message.id)) {
                        return;
                    }
                    this.messages.push(message);
                    this.$nextTick(() => this.scroll());
                },

                send() {
                    const text = (this.body || '').trim();
                    if (!text || this.sending) {
                        return;
                    }
                    this.sending = true;

                    window.axios.post(this.sendUrl, { body: text })
                        .then((response) => {
                            this.body = '';
                            this.append(response.data.message);
                        })
                        .catch(() => {})
                        .finally(() => { this.sending = false; });
                },

                markRead() {
                    if (!this.readUrl) {
                        return;
                    }
                    window.axios.post(this.readUrl).catch(() => {});
                },

                scroll() {
                    const el = this.$refs.body;
                    if (el) {
                        el.scrollTop = el.scrollHeight;
                    }
                },
            };
        }
    </script>
@endpush
