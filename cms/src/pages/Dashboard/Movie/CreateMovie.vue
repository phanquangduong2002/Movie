<template>
    <div class="mt-[8px] mb-24 pr-6 pl-8">
        <div class="text-sm breadcrumbs">
            <ul class="justify-start">
                <li><router-link :to="{ name: 'dashboard-homepage' }" class="text-primary">Quản trị</router-link></li>
                <li><router-link :to="{ name: 'dashboard-movie' }" class="text-primary">Phim</router-link></li>
                <li>Thêm phim</li>
            </ul>
        </div>
        <form>
            <div v-if="loading" class="flex items-center justify-center min-h-[30vh]">
                <span class="loading loading-spinner text-primary"></span>
            </div>
            <div v-if="!loading" class="w-[75%] mt-5 text-[15px]">
                <div role="tablist" class="tabs tabs-lifted flex items-center justify-start">
                    <a role="tab" class="tab text-gray-400 font-bold opacity-60" :class="tapActive === 1 && 'tab-active'" @click="tapActive = 1">Thông tin phim</a>
                    <a role="tab" class="tab text-gray-400 font-bold opacity-60" :class="tapActive === 2 && 'tab-active'" @click="tapActive = 2">Phân loại</a>
                    <a role="tab" class="tab text-gray-400 font-bold opacity-60" :class="tapActive === 3 && 'tab-active'" @click="tapActive = 3">Danh sách tập phim</a>
                    <a role="tab" class="tab text-gray-400 font-bold opacity-60" :class="tapActive === 4 && 'tab-active'" @click="tapActive = 4">Cập nhật phim</a>
                    <a role="tab" class="tab text-gray-400 font-bold opacity-60" :class="tapActive === 5 && 'tab-active'" @click="tapActive = 5">Khác</a>
                    <a role="tab" class="tab text-gray-400 opacity-60 flex-1"></a>
                </div>
                <div v-if="tapActive === 1" class="p-6 bg-white border-r-[1px] border-l-[1px] border-b-[1px] border-gray-400 rounded-b-lg">
                    <div class="grid grid-cols-2 gap-x-6 gap-y-4">
                        <label for="name">
                            <div class="mb-2 text-gray-700 font-bold" :class="errors.hasOwnProperty('name') ? 'text-red-500' : 'text-gray-700'">Tên phim <span class="text-red-500">*</span></div>
                            <input
                                type="text"
                                id="name"
                                v-model="name"
                                placeholder="Tên phim"
                                class="input rounded-md outline-none bg-white h-10 w-full focus:outline-none placeholder:text-sm placeholder:text-gray-400 transition-all duration-300"
                                :class="errors.hasOwnProperty('name') ? 'border-red-500 focus:border-red-500' : 'border-gray-300 focus:border-gray-500'"
                            />
                            <div v-if="errors.hasOwnProperty('name')" class="mt-1">
                                <p v-for="(message, index) in errors.name" :key="index" class="text-red-500">{{ message }}</p>
                            </div>
                        </label>
                        <label for="origin_name">
                            <div class="mb-2 text-gray-700 font-bold" :class="errors.hasOwnProperty('origin_name') ? 'text-red-500' : 'text-gray-700'">
                                Tên tiếng anh <span class="text-red-500">*</span>
                            </div>
                            <input
                                type="text"
                                id="origin_name"
                                v-model="origin_name"
                                placeholder="Tên tiếng anh"
                                class="input rounded-md outline-none bg-white h-10 w-full focus:outline-none placeholder:text-sm placeholder:text-gray-400 transition-all duration-300"
                                :class="errors.hasOwnProperty('name') ? 'border-red-500 focus:border-red-500' : 'border-gray-300 focus:border-gray-500'"
                            />
                            <div v-if="errors.hasOwnProperty('origin_name')" class="mt-1">
                                <p v-for="(message, index) in errors.origin_name" :key="index" class="text-red-500">{{ message }}</p>
                            </div>
                        </label>
                        <label for="thumb_url" class="col-span-2">
                            <div class="mb-2 text-gray-700 font-bold">Thumbnail</div>
                            <input
                                type="text"
                                id="thumb_url"
                                v-model="thumb_url"
                                placeholder=""
                                class="input rounded-md border-gray-300 outline-none bg-white h-10 w-full focus:outline-none focus:border-gray-500 placeholder:text-sm placeholder:text-gray-400 transition-all duration-300"
                            />
                        </label>
                        <label for="poster_url" class="col-span-2">
                            <div class="mb-2 text-gray-700 font-bold">Poster</div>
                            <input
                                type="text"
                                id="poster_url"
                                v-model="poster_url"
                                placeholder=""
                                class="input rounded-md border-gray-300 outline-none bg-white h-10 w-full focus:outline-none focus:border-gray-500 placeholder:text-sm placeholder:text-gray-400 transition-all duration-300"
                            />
                        </label>
                        <label for="content" class="col-span-2">
                            <div class="mb-2 text-gray-700 font-bold">Nội dung</div>
                            <ckeditor :editor="editor" v-model="content" :config="editorConfig"></ckeditor>
                        </label>
                        <label for="notify" class="col-span-2">
                            <div class="mb-2 text-gray-700 font-bold">Thông báo / ghi chú</div>
                            <input
                                type="text"
                                id="notify"
                                v-model="notify"
                                placeholder=""
                                class="input rounded-md border-gray-300 outline-none bg-white h-10 w-full focus:outline-none focus:border-gray-500 placeholder:text-sm placeholder:text-gray-400 transition-all duration-300"
                            />
                        </label>
                        <label for="showtimes" class="col-span-2">
                            <div class="mb-2 text-gray-700 font-bold">Lịch chiếu phim</div>
                            <input
                                type="text"
                                id="showtimes"
                                v-model="showtimes"
                                placeholder=""
                                class="input rounded-md border-gray-300 outline-none bg-white h-10 w-full focus:outline-none focus:border-gray-500 placeholder:text-sm placeholder:text-gray-400 transition-all duration-300"
                            />
                        </label>
                        <label for="trailer_url" class="col-span-2">
                            <div class="mb-2 text-gray-700 font-bold">Trailer URL</div>
                            <input
                                type="text"
                                id="trailer_url"
                                v-model="trailer_url"
                                placeholder=""
                                class="input rounded-md border-gray-300 outline-none bg-white h-10 w-full focus:outline-none focus:border-gray-500 placeholder:text-sm placeholder:text-gray-400 transition-all duration-300"
                            />
                        </label>
                        <div class="col-span-2 grid grid-cols-3 gap-x-6 gap-y-4">
                            <label for="episode_time" class="">
                                <div class="mb-2 text-gray-700 font-bold">Thời lượng tập phim</div>
                                <input
                                    type="text"
                                    id="episode_time"
                                    v-model="episode_time"
                                    placeholder=""
                                    class="input rounded-md border-gray-300 outline-none bg-white h-10 w-full focus:outline-none focus:border-gray-500 placeholder:text-sm placeholder:text-gray-400 transition-all duration-300"
                                />
                            </label>
                            <label for="episode_current" class="">
                                <div class="mb-2 text-gray-700 font-bold">Tập phim hiện tại</div>
                                <input
                                    type="text"
                                    id="episode_current"
                                    v-model="episode_current"
                                    placeholder=""
                                    class="input rounded-md border-gray-300 outline-none bg-white h-10 w-full focus:outline-none focus:border-gray-500 placeholder:text-sm placeholder:text-gray-400 transition-all duration-300"
                                />
                            </label>
                            <label for="episode_total" class="">
                                <div class="mb-2 text-gray-700 font-bold">Tổng số tập phim</div>
                                <input
                                    type="text"
                                    id="episode_total"
                                    v-model="episode_total"
                                    placeholder=""
                                    class="input rounded-md border-gray-300 outline-none bg-white h-10 w-full focus:outline-none focus:border-gray-500 placeholder:text-sm placeholder:text-gray-400 transition-all duration-300"
                                />
                            </label>
                            <label for="language" class="">
                                <div class="mb-2 text-gray-700 font-bold">Ngôn ngữ</div>
                                <input
                                    type="text"
                                    id="language"
                                    v-model="language"
                                    placeholder="Vietsub"
                                    class="input rounded-md border-gray-300 outline-none bg-white h-10 w-full focus:outline-none focus:border-gray-500 placeholder:text-sm placeholder:text-gray-400 transition-all duration-300"
                                />
                            </label>
                            <label for="quality" class="">
                                <div class="mb-2 text-gray-700 font-bold">Chất lượng</div>
                                <input
                                    type="text"
                                    id="quality"
                                    v-model="quality"
                                    placeholder="HD"
                                    class="input rounded-md border-gray-300 outline-none bg-white h-10 w-full focus:outline-none focus:border-gray-500 placeholder:text-sm placeholder:text-gray-400 transition-all duration-300"
                                />
                            </label>
                            <label for="year" class="">
                                <div class="mb-2 text-gray-700 font-bold">Năm sản xuất</div>
                                <input
                                    type="text"
                                    id="year"
                                    v-model="year"
                                    placeholder=""
                                    class="input rounded-md border-gray-300 outline-none bg-white h-10 w-full focus:outline-none focus:border-gray-500 placeholder:text-sm placeholder:text-gray-400 transition-all duration-300"
                                />
                            </label>
                        </div>
                    </div>
                </div>
                <div v-if="tapActive === 2" class="p-6 bg-white border-r-[1px] border-l-[1px] border-b-[1px] border-gray-400 rounded-b-lg">
                    <div class="grid grid-cols-2 gap-x-6 gap-y-4">
                        <div class="col-span-2">
                            <div class="mb-2 text-gray-700 font-bold" :class="errors.hasOwnProperty('type') ? 'text-red-500' : 'text-gray-700'">Định dạng <span class="text-red-500">*</span></div>
                            <label class="w-auto max-w-[160px] flex items-center justify-start gap-2">
                                <input type="radio" name="type" class="" v-model="type" value="single" />
                                <span>Phim lẻ</span>
                            </label>
                            <label class="w-auto max-w-[160px] flex items-center justify-start gap-2">
                                <input type="radio" name="type" class="" v-model="type" value="series" />
                                <span>Phim bộ</span>
                            </label>
                            <label class="w-auto max-w-[160px] flex items-center justify-start gap-2">
                                <input type="radio" name="type" class="" v-model="type" value="cartoon" />
                                <span>Phim hoạt hình</span>
                            </label>
                            <div v-if="errors.hasOwnProperty('type')" class="mt-1">
                                <p v-for="(message, index) in errors.type" :key="index" class="text-red-500">{{ message }}</p>
                            </div>
                        </div>
                        <div class="col-span-2">
                            <div class="mb-2 text-gray-700 font-bold" :class="errors.hasOwnProperty('status') ? 'text-red-500' : 'text-gray-700'">Tình trạng <span class="text-red-500">*</span></div>
                            <label class="w-auto max-w-[160px] flex items-center justify-start gap-2">
                                <input type="radio" name="status" class="" v-model="status" value="trailer" />
                                <span>Sắp chiếu</span>
                            </label>
                            <label class="w-auto max-w-[160px] flex items-center justify-start gap-2">
                                <input type="radio" name="status" class="" v-model="status" value="ongoing" />
                                <span>Đang chiếu</span>
                            </label>
                            <label class="w-auto max-w-[160px] flex items-center justify-start gap-2">
                                <input type="radio" name="status" class="" v-model="status" value="completed" />
                                <span>Hoàn thành</span>
                            </label>
                            <div v-if="errors.hasOwnProperty('status')" class="mt-1">
                                <p v-for="(message, index) in errors.status" :key="index" class="text-red-500">{{ message }}</p>
                            </div>
                        </div>
                        <div class="col-span-2">
                            <div class="mb-2 text-gray-700 font-bold">Thể loại</div>
                            <div class="grid grid-cols-4 gap-2">
                                <div class="form-control" v-for="category in categories" :key="category.id">
                                    <label class="cursor-pointer label justify-start gap-2 p-0">
                                        <input type="checkbox" @click="toggleCategory(category.id)" />
                                        <span class="label-text">{{ category.name }}</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-2">
                            <div class="mb-2 text-gray-700 font-bold">Khu vực</div>
                            <div class="grid grid-cols-4 gap-2">
                                <div class="form-control" v-for="region in regions" :key="region.id">
                                    <label class="cursor-pointer label justify-start gap-2 p-0">
                                        <input type="checkbox" @click="toggleRegion(region.id)" />
                                        <span class="label-text">{{ region.name }}</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="tapActive === 3" class="p-6 bg-white border-r-[1px] border-l-[1px] border-b-[1px] border-gray-400 rounded-b-lg">
                    <div class="grid grid-cols-2 mb-6">
                        <label for="server_name" class="flex items-center justify-start">
                            <input
                                type="text"
                                id="server_name"
                                v-model="server_name"
                                placeholder=""
                                class="input rounded-l-md rounded-r-none border-gray-300 outline-none bg-white h-10 w-full focus:outline-none focus:border-gray-500 text-sm placeholder:text-sm placeholder:text-gray-400 transition-all duration-300"
                            />
                            <button @click="addServer" class="btn h-10 min-h-10 px-3 gap-1 rounded-l-none rounded-r-md border-none bg-green hover:bg-green hover:opacity-80 text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none">
                                    <g>
                                        <path id="Vector" d="M6 12H12M12 12H18M12 12V18M12 12V6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </g>
                                </svg>
                                Thêm
                            </button>
                        </label>
                    </div>
                    <div role="tablist" class="tabs tabs-lifted flex items-center justify-start">
                        <a
                            v-for="(server, i) in servers"
                            :key="i"
                            role="tab"
                            class="tab text-gray-400 font-bold opacity-60"
                            :class="tapActiveServer === server && 'tab-active'"
                            @click="tapActiveServer = server"
                        >
                            {{ server }}
                        </a>
                        <a v-if="servers.length > 0" role="tab" class="tab text-gray-400 opacity-60 flex-1"></a>
                    </div>
                    <div v-if="servers.length > 0" class="p-6 bg-white border-r-[1px] border-l-[1px] border-b-[1px] border-gray-400 rounded-b-lg">
                        <div class="overflow-x-auto overflow-y-auto max-h-[500px] mb-10">
                            <table class="table">
                                <thead>
                                    <tr class="border-b-gray-300">
                                        <th class="text-sm opacity-80">Name</th>
                                        <th class="text-sm opacity-80">Type</th>
                                        <th class="text-sm opacity-80">Link tập phim</th>
                                        <th class="text-sm opacity-80">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(data, index) in episodes" :key="index" class="border-b-gray-300 text-gray-500" :class="{ hidden: data.server !== tapActiveServer }">
                                        <td class="w-[20%]">
                                            <input
                                                type="text"
                                                v-model="episodes[index].name"
                                                placeholder=""
                                                class="input rounded border-gray-300 outline-none bg-white h-10 w-full focus:outline-none focus:border-gray-500 text-sm placeholder:text-sm placeholder:text-gray-400 transition-all duration-300"
                                            />
                                        </td>
                                        <td>
                                            <select
                                                v-model="episodes[index].type"
                                                class="select rounded border-gray-300 outline-none bg-white h-10 min-h-10 w-full focus:outline-none focus:border-gray-500 text-sm placeholder:text-sm placeholder:text-gray-400 transition-all duration-300"
                                            >
                                                <option>Embed</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input
                                                type="text"
                                                v-model="episodes[index].link"
                                                placeholder=""
                                                class="input rounded border-gray-300 outline-none bg-white h-10 w-full focus:outline-none focus:border-gray-500 text-sm placeholder:text-sm placeholder:text-gray-400 transition-all duration-300"
                                            />
                                        </td>
                                        <td>
                                            <button @click.prevent="deleteEpisode(index)" class="btn h-10 min-h-10 rounded bg-red-500 text-white hover:bg-red-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14px" height="14px" viewBox="-3 0 32 32">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <g id="Icon-Set-Filled" transform="translate(-261.000000, -205.000000)" fill="currentColor">
                                                            <path
                                                                d="M268,220 C268,219.448 268.448,219 269,219 C269.552,219 270,219.448 270,220 L270,232 C270,232.553 269.552,233 269,233 C268.448,233 268,232.553 268,232 L268,220 L268,220 Z M273,220 C273,219.448 273.448,219 274,219 C274.552,219 275,219.448 275,220 L275,232 C275,232.553 274.552,233 274,233 C273.448,233 273,232.553 273,232 L273,220 L273,220 Z M278,220 C278,219.448 278.448,219 279,219 C279.552,219 280,219.448 280,220 L280,232 C280,232.553 279.552,233 279,233 C278.448,233 278,232.553 278,232 L278,220 L278,220 Z M263,233 C263,235.209 264.791,237 267,237 L281,237 C283.209,237 285,235.209 285,233 L285,217 L263,217 L263,233 L263,233 Z M277,209 L271,209 L271,208 C271,207.447 271.448,207 272,207 L276,207 C276.552,207 277,207.447 277,208 L277,209 L277,209 Z M285,209 L279,209 L279,207 C279,205.896 278.104,205 277,205 L271,205 C269.896,205 269,205.896 269,207 L269,209 L263,209 C261.896,209 261,209.896 261,211 L261,213 C261,214.104 261.895,214.999 262.999,215 L285.002,215 C286.105,214.999 287,214.104 287,213 L287,211 C287,209.896 286.104,209 285,209 L285,209 Z"
                                                            ></path>
                                                        </g>
                                                    </g>
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="flex items-center justify-start gap-4">
                            <button @click.prevent="addEpisode()" class="btn gap-1 h-10 min-h-10 rounded-md border-none bg-green hover:bg-green hover:opacity-80 text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none">
                                    <g>
                                        <path id="Vector" d="M6 12H12M12 12H18M12 12V18M12 12V6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </g></svg
                                >Thêm tập mới
                            </button>
                            <button @click="deleteServer" class="btn gap-1 h-10 min-h-10 rounded-md border-none bg-red-500 hover:bg-red-600 text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14px" height="14px" viewBox="-3 0 32 32">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <g id="Icon-Set-Filled" transform="translate(-261.000000, -205.000000)" fill="currentColor">
                                            <path
                                                d="M268,220 C268,219.448 268.448,219 269,219 C269.552,219 270,219.448 270,220 L270,232 C270,232.553 269.552,233 269,233 C268.448,233 268,232.553 268,232 L268,220 L268,220 Z M273,220 C273,219.448 273.448,219 274,219 C274.552,219 275,219.448 275,220 L275,232 C275,232.553 274.552,233 274,233 C273.448,233 273,232.553 273,232 L273,220 L273,220 Z M278,220 C278,219.448 278.448,219 279,219 C279.552,219 280,219.448 280,220 L280,232 C280,232.553 279.552,233 279,233 C278.448,233 278,232.553 278,232 L278,220 L278,220 Z M263,233 C263,235.209 264.791,237 267,237 L281,237 C283.209,237 285,235.209 285,233 L285,217 L263,217 L263,233 L263,233 Z M277,209 L271,209 L271,208 C271,207.447 271.448,207 272,207 L276,207 C276.552,207 277,207.447 277,208 L277,209 L277,209 Z M285,209 L279,209 L279,207 C279,205.896 278.104,205 277,205 L271,205 C269.896,205 269,205.896 269,207 L269,209 L263,209 C261.896,209 261,209.896 261,211 L261,213 C261,214.104 261.895,214.999 262.999,215 L285.002,215 C286.105,214.999 287,214.104 287,213 L287,211 C287,209.896 286.104,209 285,209 L285,209 Z"
                                            ></path>
                                        </g>
                                    </g></svg
                                >Xóa server
                            </button>
                        </div>
                    </div>
                </div>
                <div v-if="tapActive === 4" class="p-6 bg-white border-r-[1px] border-l-[1px] border-b-[1px] border-gray-400 rounded-b-lg">Cập nhật phim</div>
                <div v-if="tapActive === 5" class="p-6 bg-white border-r-[1px] border-l-[1px] border-b-[1px] border-gray-400 rounded-b-lg">
                    <div class="flex flex-col gap-2">
                        <div class="form-control">
                            <label class="cursor-pointer label justify-start gap-2 p-0">
                                <input type="checkbox" v-model="is_show_in_theater" />
                                <span class="label-text">Phim chiếu rạp</span>
                            </label>
                        </div>
                        <div class="form-control">
                            <label class="cursor-pointer label justify-start gap-2 p-0">
                                <input type="checkbox" v-model="is_copyright" />
                                <span class="label-text">Có bản quyền</span>
                            </label>
                        </div>
                        <div class="form-control">
                            <label class="cursor-pointer label justify-start gap-2 p-0">
                                <input type="checkbox" v-model="is_sensitive_content" />
                                <span class="label-text">Phim có nội dung 18+</span>
                            </label>
                        </div>
                        <div class="form-control">
                            <label class="cursor-pointer label justify-start gap-2 p-0">
                                <input type="checkbox" v-model="is_recommended" />
                                <span class="label-text">Phim đề cử</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="mt-2 flex items-center justify-start gap-3">
                    <button @click="create" class="btn h-10 min-h-10 px-6 bg-green hover:bg-green hover:opacity-80 text-white text-base">
                        <span v-if="!loadingSubmit" class="flex-1 flex items-center justify-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none">
                                <path
                                    fill-rule="evenodd"
                                    clip-rule="evenodd"
                                    d="M18.1716 1C18.702 1 19.2107 1.21071 19.5858 1.58579L22.4142 4.41421C22.7893 4.78929 23 5.29799 23 5.82843V20C23 21.6569 21.6569 23 20 23H4C2.34315 23 1 21.6569 1 20V4C1 2.34315 2.34315 1 4 1H18.1716ZM4 3C3.44772 3 3 3.44772 3 4V20C3 20.5523 3.44772 21 4 21L5 21L5 15C5 13.3431 6.34315 12 8 12L16 12C17.6569 12 19 13.3431 19 15V21H20C20.5523 21 21 20.5523 21 20V6.82843C21 6.29799 20.7893 5.78929 20.4142 5.41421L18.5858 3.58579C18.2107 3.21071 17.702 3 17.1716 3H17V5C17 6.65685 15.6569 8 14 8H10C8.34315 8 7 6.65685 7 5V3H4ZM17 21V15C17 14.4477 16.5523 14 16 14L8 14C7.44772 14 7 14.4477 7 15L7 21L17 21ZM9 3H15V5C15 5.55228 14.5523 6 14 6H10C9.44772 6 9 5.55228 9 5V3Z"
                                    fill="currentColor"
                                /></svg
                            >Lưu
                        </span>
                        <span v-if="loadingSubmit" class="loading loading-spinner text-white text-sm"></span>
                    </button>
                    <button @click="cancel" class="btn h-10 min-h-10 px-6 bg-red-500 hover:bg-red-600 text-white text-base">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none">
                            <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2" />
                            <path d="M18 18L6 6" stroke="currentColor" stroke-width="2" /></svg
                        >Hủy
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import { defineComponent, ref, reactive, toRefs } from 'vue'
import { useRouter } from 'vue-router'
import ClassicEditor from '@ckeditor/ckeditor5-build-classic'

import { getAllCategory } from '../../../webServices/categoryService'
import { getAllRegion } from '../../../webServices/regionService'
import { createMovie } from '../../../webServices/movieService'

export default defineComponent({
    setup() {
        const router = useRouter()

        const tapActive = ref(1)

        const loading = ref(false)
        const loadingSubmit = ref(false)
        const errors = ref({})

        const categories = ref([])
        const regions = ref([])

        const fileThumbnail = ref(null)
        const thumbUrl = ref(null)

        const filePoster = ref(null)
        const posterUrl = ref(null)

        const movie = reactive({
            name: '',
            origin_name: '',
            thumb_url: '',
            poster_url: '',
            content: '',
            notify: '',
            showtimes: '',
            trailer_url: '',
            episode_time: '',
            episode_current: '',
            episode_total: '',
            language: '',
            quality: '',
            year: '',
            type: '',
            status: '',
            episodes: [],
            view_total: 0,
            view_day: 0,
            view_week: 0,
            view_month: 0,
            rating_count: 0,
            rating_star: 0,
            category_ids: [],
            region_ids: [],
            is_show_in_theater: false,
            is_recommended: false,
            is_copyright: false,
            is_sensitive_content: false
        })

        const tapActiveServer = ref('Vietsub #1')

        const server_name = ref('Thuyết minh #1')

        const servers = ref(['Vietsub #1'])

        const episodes = ref([])

        const handleFileThumbnail = async e => {
            fileThumbnail.value = e.target.files[0]

            thumbUrl.value = URL.createObjectURL(fileThumbnail.value)
        }

        const handleFilePoster = async e => {
            filePoster.value = e.target.files[0]

            posterUrl.value = URL.createObjectURL(filePoster.value)
        }

        const create = async e => {
            e.preventDefault()
            loadingSubmit.value = true
            errors.value = {}

            movie.episodes = episodes.value

            const data = await createMovie(movie)

            if (data && data.status === 422) errors.value = data.data.errors

            if (data && data.success) {
                router.push({ name: 'dashboard-movie' })
            }

            loadingSubmit.value = false
        }

        const cancel = e => {
            e.preventDefault()
            router.push({ name: 'dashboard-movie' })
        }

        const addServer = e => {
            e.preventDefault()

            servers.value.push(server_name.value)

            if (servers.value.length === 1) tapActiveServer.value = servers.value[0]
        }

        const deleteServer = e => {
            e.preventDefault()

            episodes.value = episodes.value.filter(episode => episode.server !== tapActiveServer.value)

            const index = servers.value.indexOf(tapActiveServer.value)

            servers.value.splice(index, 1)

            if (servers.value.length > 0) tapActiveServer.value = servers.value[0]
            else tapActiveServer.value = null
        }

        const addEpisode = () => {
            episodes.value.push({
                name: '',
                server: tapActiveServer.value,
                type: 'Embed',
                link: ''
            })
        }

        const deleteEpisode = i => {
            episodes.value.splice(i, 1)
        }

        return {
            tapActive,
            tapActiveServer,
            loading,
            loadingSubmit,
            errors,
            categories,
            regions,
            fileThumbnail,
            thumbUrl,
            filePoster,
            posterUrl,
            ...toRefs(movie),
            server_name,
            servers,
            episodes,
            handleFileThumbnail,
            handleFilePoster,
            create,
            cancel,
            addServer,
            deleteServer,
            addEpisode,
            deleteEpisode,
            editor: ClassicEditor,
            editorConfig: {}
        }
    },
    methods: {
        async getData() {
            this.loading = true

            const [categories, regions] = await Promise.all([getAllCategory(), getAllRegion()])

            if (categories && categories.success) this.categories = categories.categories
            if (regions && regions.success) this.regions = regions.regions

            this.loading = false
        },
        toggleCategory(id) {
            const index = this.category_ids.indexOf(id)
            if (index !== -1) {
                this.category_ids.splice(index, 1)
            } else {
                this.category_ids.push(id)
            }
        },
        toggleRegion(id) {
            const index = this.region_ids.indexOf(id)
            if (index !== -1) {
                this.region_ids.splice(index, 1)
            } else {
                this.region_ids.push(id)
            }
        }
    },
    computed: {},
    created() {
        this.getData()
    }
})
</script>

<style scoped>
.ck-editor__editable {
    min-height: 500px;
}
</style>
