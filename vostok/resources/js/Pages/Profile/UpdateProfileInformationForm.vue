<template>
    <jet-form-section @submitted="updateProfileInformation">
        <template #title>
            Общая информация
        </template>

        <template #form>

            <!-- Name -->
            <div class="profile-inputs">
                <jet-label for="lastname" value="Фамилия"/>
                <jet-input id="lastname" type="text" disabled class="mt-1 block w-full" v-model="form.lastname"
                           autocomplete="lastname"/>
                <jet-input-error :message="form.error('lastname')" class="mt-2"/>
            </div>
            <!-- Name -->
            <div class="profile-inputs">
                <jet-label for="firstname" value="Имя"/>
                <jet-input id="firstname" type="text" disabled class="mt-1 block w-full" v-model="form.firstname"
                           autocomplete="firstname"/>
                <jet-input-error :message="form.error('firstname')" class="mt-2"/>
            </div>

            <!-- Name -->
            <div class="profile-inputs">
                <jet-label for="middlename" value="Отчество"/>
                <jet-input id="middlename" type="text" disabled class="mt-1 block w-full" v-model="form.middlename"
                           autocomplete="middlename"/>
                <jet-input-error :message="form.error('middlename')" class="mt-2"/>
            </div>
            <div class="profile-inputs">
                <jet-label for="position" value="Должность"/>
                <jet-input id="position" type="text" disabled class="mt-1 block w-full" v-model="form.position"
                           autocomplete="position"/>
                <jet-input-error :message="form.error('middlename')" class="mt-2"/>
            </div>
            <div class="profile-wrap">
                <!-- Email -->
                <div class="profile-inputs profile-inputs__last">
                    <jet-label for="email" value="Email"/>
                    <jet-input id="email" type="email" disabled class="mt-1 block w-full" v-model="form.email"/>
                    <jet-input-error :message="form.error('email')" class="mt-2"/>
                </div>
                <!-- Phone -->
                <div class="profile-inputs profile-inputs__last">
                    <jet-label for="phone" value="Номер телефона"/>
                    <jet-input id="phone" type="tel" disabled class="mt-1 block w-full" v-model="form.phone"/>
                    <jet-input-error :message="form.error('phone')" class="mt-2"/>
                </div>
            </div>
        </template>

        <template #actions>
            <jet-action-message :on="form.recentlySuccessful">
                Saved.
            </jet-action-message>

            <jet-button :disabled="form.processing">
                Сохранить
            </jet-button>
        </template>
    </jet-form-section>
</template>

<script>
import JetButton from './../../Jetstream/Button'
import JetFormSection from './../../Jetstream/FormSection'
import JetInput from './../../Jetstream/Input'
import JetInputError from './../../Jetstream/InputError'
import JetLabel from './../../Jetstream/Label'
import JetActionMessage from './../../Jetstream/ActionMessage'
import JetSecondaryButton from './../../Jetstream/SecondaryButton'

export default {
    components: {
        JetActionMessage,
        JetButton,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
        JetSecondaryButton,
    },

    props: ['firstname', 'lastname', 'middlename', 'phone', 'email'],

    data() {
        return {
            form: this.$inertia.form({
                '_method': 'PUT',
                lastname: this.lastname,
                firstname: this.firstname,
                middlename: this.middlename,
                email: this.email,
                phone: this.phone,
                photo: null,
                position: this.position
            }, {
                bag: 'updateProfileInformation',
                resetOnSuccess: false,
            }),

            photoPreview: null,
        }
    },

    methods: {
        updateProfileInformation() {
            if (this.$refs.photo) {
                this.form.photo = this.$refs.photo.files[0]
            }

            this.form.post(route('user-profile-information.update'), {
                preserveScroll: true
            });
        },

        selectNewPhoto() {
            this.$refs.photo.click();
        },

        updatePhotoPreview() {
            const reader = new FileReader();

            reader.onload = (e) => {
                this.photoPreview = e.target.result;
            };

            reader.readAsDataURL(this.$refs.photo.files[0]);
        },

        deletePhoto() {
            this.$inertia.delete(route('current-user-photo.destroy'), {
                preserveScroll: true,
            }).then(() => {
                this.photoPreview = null
            });
        },
    },
}
</script>
