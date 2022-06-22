<template>
    <div>
        <div class="card">
            <div class="card-content">
                <span class="card-title">Lucas {{replied}}</span>

                <blockquote>
                    Texto de resposta
                </blockquote>
            </div>
        </div>
        <div class="card">
            <div class="card-content">
                <span class="card-title">Lucas {{replied}}</span>

                <blockquote>
                    Texto de resposta
                </blockquote>
            </div>
        </div>
        <div class="card grery lighten-4">
            <div class="card-content">
                <span class="card-title">{{reply}}</span>

                <form>
                    <div class="input-field">
                        <textarea rows="10" class="materialize-textarea" :placeholder="yourAnswer"></textarea>
                    </div>
                    <button type="submit" class="btn red accent-2">{{send}}</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:[
            'replied',
            'reply',
            'yourAnswer',
            'send'
        ]
    }
</script>
