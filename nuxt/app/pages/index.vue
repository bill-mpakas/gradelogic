<script setup lang="ts">
import { ModalDemo } from "#components";

const modal = useModal();
const router = useRouter();
const auth = useAuthStore();

const classrooms = ref([]);

const fetchClassrooms = async () => {
  const { data } = await useFetch('classrooms');
  classrooms.value = data;
};


function openDemoModal() {
  modal.open(ModalDemo);
}

useSeoMeta({
  title: "Home",
});
</script>

<template>
  <div class="grid grid-cols-12 gap-6">
    <div class="col-span-12 lg:col-span-3">
      <UCard>
        <div class="font-bold text-lg leading-tight tracking-tighter mb-4">
          Demo
        </div>

        <div class="flex gap-3">
          <UButton label="Modal" @click="openDemoModal" color="gray" />
          <UButton label="404 page" color="gray" @click="router.push('/404')" />
        </div>
      </UCard>
    </div>
    <div class="col-span-12 lg:col-span-9">
      <UCard>
        <div class="font-bold text-lg leading-tight tracking-tighter mb-4">
          User Object
        </div>
        <pre>{{ auth.user }}</pre>
        Token: {{ auth.token }}
      </UCard>
      <UCard>
        <div class="font-bold text-lg leading-tight tracking-tighter mb-4">
          Classrooms
        </div>
        <UButton label="Fetch Classrooms" @click="fetchClassrooms" />
        <pre>{{ classrooms }}</pre>
      </UCard>
    </div>
  </div>
</template>
