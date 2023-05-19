<template>
  <header class="header">
    <div class="container">
      <div class="header-i">
        <div class="logo">
          <router-link v-if="!isHomepage" :to="{ name: 'Home' }"
            ><img
              :src="`${publicPath}logo.png`"
              :srcset="`${publicPath}logo.png, ${publicPath}logo@2x.png 2x`"
              alt="StreamGeeks"
          /></router-link>
          <span v-else
            ><img
              :src="`${publicPath}logo.png`"
              :srcset="`${publicPath}logo.png, ${publicPath}logo@2x.png 2x`"
              alt="StreamGeeks"
          /></span>
        </div>

        <div class="header-r">
          <!-- Main Navigation -->
          <nav class="header-menu" :class="mmenuExpanded ? 'active' : ''">
            <ul>
              <li>
                <router-link :to="{ name: 'projects' }">Projects</router-link>
              </li>
              <li>
                <router-link :to="{ name: 'products' }">Products</router-link>
              </li>
              <li>
                <router-link :to="{ name: 'education' }">Education</router-link>
              </li>
              <li>
                <router-link :to="{ name: 'community' }">Community</router-link>
              </li>
              <li>
                <router-link :to="{ name: 'plans' }">Plans</router-link>
              </li>
              <li v-if="!isAuthenticated">
                <a href="#" @click.prevent="showLoginDialog">Login</a>
                <span class="sep">/</span>
                <a href="#" @click.prevent="showRegisterDialog">Register</a>
              </li>
            </ul>
            <div class="h-publish-m">
              <router-link
                class="btn btn-secondary pusblish-project"
                :to="{ name: 'projectadd' }"
                >Publish Your Project</router-link
              >
            </div>
          </nav>

          <div class="h-search">
              <span class="icon-w" @click="showSearchResult" style="cursor:pointer;">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <g clip-path="url(#clip0_14_1526)">
                  <path d="M7.04606 0C3.16097 0 0 3.16097 0 7.04606C0 10.9314 3.16097 14.0921 7.04606 14.0921C10.9314 14.0921 14.0921 10.9314 14.0921 7.04606C14.0921 3.16097 10.9314 0 7.04606 0ZM7.04606 12.7913C3.87816 12.7913 1.30081 10.214 1.30081 7.04609C1.30081 3.87819 3.87816 1.30081 7.04606 1.30081C10.214 1.30081 12.7913 3.87816 12.7913 7.04606C12.7913 10.214 10.214 12.7913 7.04606 12.7913Z" fill="#202C54"/>
                  <path d="M15.809 14.8893L12.08 11.1603C11.8259 10.9062 11.4144 10.9062 11.1603 11.1603C10.9062 11.4142 10.9062 11.8261 11.1603 12.08L14.8893 15.809C15.0164 15.936 15.1827 15.9996 15.3492 15.9996C15.5155 15.9996 15.682 15.936 15.809 15.809C16.0631 15.5551 16.0631 15.1432 15.809 14.8893Z" fill="#202C54"/>
                  </g>
                  <defs>
                  <clipPath id="clip0_14_1526">
                  <rect width="16" height="16" fill="white"/>
                  </clipPath>
                  </defs>
                </svg>
              </span>  
              <div :class="searchClass" v-if="showSearchbox">
                <input
                  class="form-control"
                  type="text"
                  v-model.trim="search"
                  placeholder="Search project / product"
                  @keyup="getFilterData"
                />
                <div class="sb-wrapper">
                  <div class="project-listing" v-if="resources.length > 0">
                    <div class="sp-title">
                      Products
                    </div>
                    <ul>
                      <li v-if="resources.length > 0" v-for="serachData in resources" :key="serachData.id">
                        <router-link :to="{ name: 'Product Page', params: { slug: serachData.slug }}" class="card-project-title">{{ serachData.name }}</router-link>
                      </li>
                    </ul>
                  </div>
                  <div class="product-listing" v-if="resourcesProject.length > 0">
                    <div class="sp-title">
                      Projects
                    </div>
                    <ul>
                      <li v-if="resourcesProject.length > 0" v-for="serachProjectData in resourcesProject" :key="serachProjectData.id">
                        <router-link :to="{ name: 'project', params: { slug: serachProjectData.slug }}" class="card-project-title">{{ serachProjectData.name }}</router-link>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>  
          </div>
          
          <div class="h-notifications" v-if="isAuthenticated">
            <div
              class="h-notifications-trigger"
              @click="notificationsDropdown = !notificationsDropdown"
            >
              <icon-base
                width="13.83"
                height="16.5"
                view-box="0 0 13.83 16.5"
                icon-name="bell"
                ><icon-bell
              /></icon-base>
              <span v-if="totalNotiCount > 0" class="noti-bubble">{{ totalNotiCount }}</span>
            </div>

            <div class="h-notifications-dropdown" v-if="notificationsDropdown">
              <div class="h-notifications-headline">
                Notifications
              </div>
              <div class="h-notifications-list">
                <!-- Manage notification for project start here -->
                <div v-if="notificationData.length > 0" class="notification mb-3" v-for="notification in notificationData" :key="notification.id">
                  <div class="d-flex" style="cursor:pointer;" @click="updateComment(notification[0].project.slug , notification[0].project.id, notification[0].user.id, 'project')">
                    <div class="notification-userpic">
                      <img
                        v-if="notification[0].user.profile_photo != null"
                        class="rounded-circle"
                        :src="notification[0].user.profile_photo"
                        alt=""
                      />
                      <img
                        v-else
                        class="rounded-circle"
                        :src="defaultUserImgUrl"
                        alt=""
                      />
                      <div class="notifi-icon">
                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 394 390" style="enable-background:new 0 0 394 390;" xml:space="preserve">
                          <g>
                            <path d="M340.9,127c3.9-1.8,7.2-3.9,10.8-5c12-3.8,24.9,1,32.2,11.7c7,10.3,6.7,23.8-1.3,33.5c-13,15.7-26.3,31.1-39.3,46.8
                              c-1.4,1.6-2.3,4.2-2.3,6.3c-0.1,51.9-0.1,103.7-0.1,155.6c0,1.5,0,3-0.1,4.5c-0.3,2.9-1.9,4.6-4.8,4.8c-1.4,0.1-2.7,0.1-4.1,0.1
                              c-102.2,0-204.5,0-306.7,0c-8,0-8.9-0.9-8.9-8.8c0-118.4,0-236.7,0-355.1c0-7.7,1-8.7,8.6-8.7c69.2,0,138.5,0,207.7-0.1
                              c3.9,0,6.8,1.1,9.5,4c31.5,33.2,63,66.4,94.6,99.4C339.7,119.2,341.4,122.5,340.9,127z M27.7,373.8c100.8,0,201.1,0,301.6,0
                              c0-47.6,0-95,0-143.2c-1.7,2-2.9,3.3-4.1,4.7c-25.1,29.2-50.1,58.4-75.2,87.6c-1.6,1.9-3.3,3.9-5.3,5.2
                              c-20.6,12.8-41.3,25.4-61.9,38.1c-2.8,1.7-5.6,2-8.3-0.3c-2.7-2.3-1.7-4.8-0.6-7.5c8.7-20.7,17.2-41.5,26.2-62.1
                              c2-4.6,4.7-9.1,8-12.9c39.1-46.2,78.2-92.3,117.7-138.1c4.7-5.4,3.7-10.7,3.8-16.8c-1.9,0-3.4,0-4.9,0c-28.9,0-57.7,0-86.6,0
                              c-6.9,0-8.3-1.5-8.3-8.4c0-30.5,0-61,0-91.5c0-1.4,0-2.9,0-4.3c-67.6,0-134.7,0-201.9,0C27.7,140.9,27.7,257.2,27.7,373.8z
                              M323.4,165.1c-36,42.2-71.8,84.3-107.8,126.5c9.2,7.9,18.1,15.4,27.1,23.1c36.1-42.3,71.9-84.3,107.8-126.5
                              C341.4,180.5,332.5,172.9,323.4,165.1z M322.1,117c-27-28.4-53.5-56.1-80.4-84.3c0,28.6,0,56.3,0,84.3
                              C268.3,117,294.7,117,322.1,117z M357.8,179.2c5.5-6.3,10.7-12.2,15.7-18.2c6.1-7.4,4.9-18-2.5-24.5c-7.3-6.4-18.3-6-24.6,1
                              c-5.3,5.9-10.3,12.1-15.7,18.5C339.7,163.8,348.6,171.3,357.8,179.2z M233.6,321.5c-8-6.8-15.7-13.4-23.7-20.3
                              c-6.4,15.7-12.6,30.7-18.7,45.8c0.2,0.1,0.5,0.3,0.7,0.4C205.6,338.8,219.4,330.3,233.6,321.5z"/>
                            <path d="M155.7,68.5c3.3-2.4,6.6-4.9,9.9-7.3c3.5-2.5,5.6-2.4,8.6,0.5c3.4,3.3,6.8,6.7,10.1,10.1c3.2,3.3,3.3,5.8,0.5,9.6
                              c-2.3,3-4.6,5.9-6.7,8.6c1.9,5,3.6,9.7,5.6,14.4c0.3,0.7,1.6,1.4,2.5,1.5c3.3,0.6,6.7,0.9,10,1.5c3.9,0.6,5.7,2.6,5.7,6.6
                              c0.1,4.9,0.1,9.7,0,14.6c-0.1,4-1.8,6-5.7,6.6c-3.3,0.5-6.7,0.8-10,1.5c-1.1,0.3-2.4,1.4-2.9,2.5c-1.3,2.7-1.8,5.8-3.4,8.3
                              c-2.4,3.6-1.6,6.3,1,9.1c1.7,1.8,3,4,4.5,6c1.9,2.6,1.9,5.2-0.4,7.5c-3.8,4-7.7,7.9-11.6,11.7c-2.4,2.3-5.1,1.6-7.5-0.2
                              c-2.6-1.9-5.1-4.1-7.8-5.9c-1-0.6-2.7-0.9-3.8-0.5c-3.8,1.3-7.5,2.8-11,4.5c-1.1,0.5-2.2,1.8-2.5,3c-0.7,2.9-0.9,5.9-1.3,8.9
                              c-0.6,4.8-2.5,6.7-7.3,6.7c-4.4,0-8.7,0-13.1,0c-4.4,0-6.4-1.7-7.1-6c-0.5-3-0.8-5.9-1.1-8.9c-0.2-2.1-1-3.3-3.2-3.9
                              c-3.1-0.9-6.3-1.9-9-3.5c-2.7-1.6-4.6-1.5-6.9,0.5c-2.2,2-4.8,3.6-7.2,5.4c-2.6,1.9-5.1,1.9-7.5-0.4c-3.9-3.8-7.8-7.7-11.7-11.7
                              c-2.2-2.3-1.8-4.8-0.1-7.2c2-2.9,4.3-5.5,6.1-8.5c0.7-1.1,0.8-3,0.4-4.2c-1.3-3.8-2.8-7.4-4.5-11.1c-0.4-0.9-1.5-1.9-2.5-2.1
                              c-3.4-0.7-6.9-1-10.4-1.5c-4.2-0.5-6.2-2.5-6.3-6.5c-0.1-5-0.1-10,0-15c0.1-3.7,2.1-5.8,5.7-6.3c3.3-0.5,6.7-0.7,10-1.5
                              c1.1-0.2,2.4-1.4,2.9-2.5c1.7-3.5,2.8-7.2,4.6-10.6c1-1.9,0.7-3.1-0.5-4.7c-2.1-2.6-4-5.4-6-8.1c-2.1-2.9-1.7-5.6,0.8-8
                              c3.6-3.5,7.1-7,10.6-10.6c2.4-2.5,5-2.6,7.7-0.7c2.9,2,5.7,4,8.4,6.2c1.6,1.3,2.8,1.3,4.6,0.3c2.4-1.4,4.9-2.7,7.5-3.2
                              c4.5-0.8,5.9-3.3,6.2-7.6c1-14.2,3.7-12.1,14-12.2c2.5,0,5,0,7.5,0c3.7,0,5.9,1.9,6.5,5.5c0.7,3.9-0.1,8.8,2,11.6
                              c1.9,2.6,6.7,3.1,10.2,4.6C152.5,66.7,154,67.6,155.7,68.5z M191.1,118.9c-3.3-0.5-6.5-1.2-9.7-1.5c-3.8-0.3-5.6-2.2-6.9-5.7
                              c-2.2-6-4.9-11.9-7.7-17.8c-1.3-2.7-1.5-4.8,0.5-7.2c2.4-2.9,4.5-5.9,7-9.2c-1.6-1.4-3-2.8-4.7-4.3c-2.5,1.9-5.2,3.8-7.7,5.8
                              c-3.2,2.7-6.3,2.5-10,0.5c-4.8-2.6-9.8-4.8-15-6.5c-4.7-1.6-6.4-2.9-7.1-7.9c-0.5-3.3-0.9-6.6-1.3-10c-2.3,0-4.2,0-6.2,0
                              c-0.5,3.8-1.1,7.4-1.5,11c-0.4,3.7-2.4,5.5-6,6.7c-5.6,1.9-11.1,4.2-16.4,6.9c-3,1.5-5.3,1.7-7.9-0.4c-2.9-2.3-5.9-4.5-8.5-6.4
                              c-1.9,1.5-3.4,2.8-5,4c2,2.7,3.8,4.9,5.5,7.2c3.4,4.5,3.2,6.2,0.7,11.2c-2.6,5.1-4.8,10.4-6.5,15.8c-1,3.2-2.5,4.9-5.7,5.4
                              c-3.5,0.6-7.1,1.1-10.6,1.7c-1,6.5-1,6.5,4.7,7.4c1.6,0.2,3.2,0.5,4.8,0.7c3.8,0.4,5.7,2.5,6.9,6.2c1.9,5.9,4.4,11.6,7,17.2
                              c1.3,2.7,1.5,4.9-0.4,7.3c-2.4,3-4.7,6.1-6.7,8.8c1.5,1.9,2.8,3.4,4,5c2.9-2.2,5.4-4.1,7.9-6c3.8-2.8,6.1-2.6,10.3-0.5
                              c5,2.5,10.1,4.9,15.4,6.5c4,1.2,5.8,3.4,6.3,7.2c0.4,3.4,1,6.9,1.5,10.2c6,1,6,1,6.8-4.5c0.3-2,0.6-4,0.8-5.9
                              c0.4-3.8,2.4-5.8,6.1-7.1c6-2.1,11.7-4.8,17.4-7.6c2.7-1.3,4.9-1.4,7.2,0.5c2.9,2.3,5.9,4.5,8.7,6.7c1.7-1.5,3.2-2.8,4.8-4.3
                              c-2-2.7-4-5.3-6-7.8c-2.7-3.6-2.5-5.9-0.4-10c2.5-5,4.8-10.1,6.6-15.4c1.6-4.9,2.4-6,7.5-6.7c3.1-0.4,6.1-0.8,9.2-1.3
                              C191.1,122.8,191.1,120.9,191.1,118.9z"/>
                            <path d="M120.6,239.1c-18,0-36,0-54,0c-1.4,0-2.8,0-4.1-0.2c-3-0.4-4.4-2.4-4.5-5.1c-0.1-2.9,1.1-5.1,4.2-5.7c1-0.2,2-0.3,3-0.3
                              c37.2,0,74.5,0,111.7,0c2.6,0,5,0.3,6.3,3c1.9,3.9-0.4,8.1-4.9,8.2c-5.6,0.2-11.2,0.1-16.9,0.1
                              C147.8,239.1,134.2,239.1,120.6,239.1z"/>
                            <path d="M116.7,277c-17,0-34,0-51,0c-1.5,0-3-0.1-4.4-0.6c-2.6-0.9-3.5-3.1-3.3-5.7c0.2-2.6,1.7-4.4,4.4-4.9
                              c0.8-0.2,1.7-0.1,2.6-0.1c34.6,0,69.2,0,103.9,0c0.7,0,1.5,0,2.2,0.1c2.7,0.3,4.3,1.8,4.7,4.5c0.4,2.6-0.6,4.8-3,5.8
                              c-1.6,0.6-3.4,0.8-5.1,0.8C150.7,277,133.7,277,116.7,277z"/>
                            <path d="M108.8,304c14.6,0,29.2,0,43.8,0c4.8,0,7.5,3.4,6.2,7.4c-1,3.1-3.5,3.9-6.5,3.8c-14.2,0-28.5,0-42.7,0c-15,0-30,0-44.9,0
                              c-3.2,0-5.7-0.9-6.5-4.3c-1-4,1.7-6.9,6.5-6.9C79.3,304,94,304,108.8,304z"/>
                            <path d="M125.3,155.5c-18.8-0.2-33.6-15.5-33.5-34.6c0.2-19.1,15.5-34.6,34.2-34.3c18.6,0.2,33.7,15.8,33.6,34.7
                              C159.5,140.4,144.1,155.7,125.3,155.5z M103.1,120.8c0,13.5,9.8,23.9,22.5,24c12.2,0,22.7-10.7,22.7-23.2
                              c0-12.7-10.1-23.1-22.6-23.1C112.9,98.5,103.1,108.1,103.1,120.8z"/>
                          </g>
                        </svg>
                      </div>
                    </div>
                    <div class="notification-info">
                      <div class="text">
                        <strong>{{ notification[0].user.full_name }}</strong> comment on <strong>{{ notification[0].project.name }}</strong> project.
                      </div>
                      <div class="date">{{ notification[0].before_day }}</div>
                    </div>
                  </div>
                </div>
                <!-- Manage notification for project end here -->

                <!-- Manage notification for product start here -->
                <div v-if="notificationProductData.length > 0" class="notification mb-3" v-for="notificationProduct in notificationProductData" :key="notificationProduct.id">
                  <div class="d-flex" style="cursor:pointer;" @click="updateComment(notificationProduct[0].product.slug , notificationProduct[0].product.id, notificationProduct[0].user.id, 'product')">
                    <div class="notification-userpic">
                      <img
                        v-if="notificationProduct[0].user.profile_photo != null"
                        class="rounded-circle"
                        :src="notificationProduct[0].user.profile_photo"
                        alt=""
                      />
                      <img
                        v-else
                        class="rounded-circle"
                        :src="defaultUserImgUrl"
                        alt=""
                      />
                      <div class="notifi-icon">
                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	                      viewBox="0 0 401 394" style="enable-background:new 0 0 401 394;" xml:space="preserve">
                          <g>
                            <path d="M8.5,337.3c2.1-4.8,5.8-6.8,11-6.5c4,0.2,7.9,0,12.4,0c0-2,0-3.6,0-5.1c0-47.5,0-95,0-142.5c0-11.5,3.8-15.4,15.2-15.4
                              c20.6,0,41.2,0,61.9,0c1.3,0,2.7,0,4.5,0c0-1.8,0-3.2,0-4.7c0-30,0-60,0-90c0-1.2-0.1-2.5,0.1-3.7c0.4-3,2.3-4.7,5.3-4.9
                              c2.8-0.2,4.8,1.4,5.6,4.1c0.4,1.4,0.3,3,0.3,4.5c0,30,0,60,0,90c0,1.5,0,2.9,0,4.6c50.6,0,100.8,0,151.3,0c0-50.2,0-100.5,0-151.1
                              c-16.5,0-33.2,0-50.5,0c0,1.2,0,2.6,0,3.9c0,10.6,0,21.2,0,31.9c-0.1,9.2-6.8,13.6-14.5,8.7c-7.5-4.8-13.6-4.6-21,0
                              c-7.7,4.8-14.4,0.4-14.5-8.8c-0.1-10.5,0-21,0-31.5c0-1.3,0-2.7,0-4.3c-17.1,0-33.7,0-50.8,0c0,7.6,0,15.1,0,22.5c0,2,0.1,4-0.1,6
                              c-0.4,3.2-2.8,5.3-5.9,5c-3.2-0.3-5.2-2.2-5.2-5.3c-0.1-9.7-0.2-19.5,0-29.2c0.1-5.5,4.8-10,10.4-10.4c1.1-0.1,2.2,0,3.4,0
                              c48.7,0,97.5,0,146.2,0c9.8,0,13.9,4.1,13.9,13.8c0,48,0,96,0,144c0,1.5,0,3,0,5c1.7,0,3.1,0,4.5,0c21.1,0,42.2,0,63.4,0
                              c9.2,0,13.6,4.4,13.6,13.5c0,33.2,0,66.5,0,99.7c0,1.5,0.2,3.4-0.6,4.3c-1.5,1.6-3.5,3.3-5.5,3.5c-2.6,0.3-4.6-1.7-5-4.6
                              c-0.2-1.4-0.1-2.7-0.1-4.1c0-32,0-64,0-96c0-1.5,0-3,0-4.8c-16.9,0-33.6,0-50.8,0c0,1.2,0,2.5,0,3.8c0,10.7,0,21.5,0,32.2
                              c0,8.6-7,13.2-14.1,8.6c-7.6-4.9-14-5-21.7-0.1c-7.4,4.7-14.3,0.1-14.4-8.7c0-11.9,0-23.7,0-35.9c-16.9,0-33.5,0-50.5,0
                              c0,50.3,0,100.6,0,151.2c50.4,0,100.7,0,151.5,0c0-5.8,0-11.4,0-17c0-1.4,0-2.8,0-4.1c0.2-3.6,2.2-5.9,5.3-6c3.3-0.1,5.7,2.2,5.8,6
                              c0.2,5.6,0,11.2,0.1,16.9c0,1.3,0,2.7,0,4.5c4.6,0,8.8,0,13,0c7.3,0.1,10.3,3.1,10.3,10.2c0,4.2,0,8.5,0,12.7
                              c0,6.9-3.1,10-10.1,10.1c-3.7,0.1-7.4,0-11.5,0c0,4.4-0.2,8.4,0.1,12.3c0.4,6.1-1.9,10.4-7.6,12.7c-7,0-14,0-21,0
                              c-5.8-2.2-8.1-6.5-7.7-12.6c0.3-4,0-8.1,0-12.2c-89.7,0-178.7,0-268.1,0c0,4.2-0.2,8.2,0,12.2c0.4,6.1-1.9,10.4-7.7,12.6
                              c-7,0-14,0-21,0c-5.7-2.4-8-6.6-7.6-12.7c0.3-4,0.1-8.1,0.1-12.4c-4,0-7.4-0.2-10.7,0c-5.2,0.3-8.9-1.6-11-6.5
                              C8.5,350.8,8.5,344,8.5,337.3z M43.4,179.3c0,50.7,0,100.9,0,151.3c50.5,0,100.8,0,151.3,0c0-50.6,0-100.9,0-151.2
                              c-16.9,0-33.6,0-50.5,0c0,12.3,0.1,24.3,0,36.3c-0.1,8.3-7.1,13-14,8.5c-7.7-5-14.2-5.1-22-0.1c-7.2,4.6-14.1,0-14.1-8.7
                              c0-10.7,0-21.5,0-32.2c0-1.3,0-2.6,0-3.9C76.8,179.3,60.2,179.3,43.4,179.3z M19.9,352.3c120.6,0,240.9,0,361.1,0c0-3.5,0-6.7,0-10
                              c-120.5,0-240.8,0-361.1,0C19.9,345.8,19.9,348.9,19.9,352.3z M105.4,212.5c4.7-1.8,9.2-4.8,13.6-4.8c4.6,0,9.1,3,13.6,4.7
                              c0-11,0-22.1,0-33.1c-9.2,0-18.1,0-27.2,0C105.4,190.5,105.4,201.4,105.4,212.5z M268.3,212.6c4.6-1.8,9.1-4.9,13.5-4.9
                              c4.6,0,9.2,3,13.8,4.7c0-11,0-22,0-33c-9.2,0-18.2,0-27.3,0C268.3,190.6,268.3,201.6,268.3,212.6z M186.9,50.8
                              c9.1-7.8,18.1-7.8,27.1-0.1c0-12.1,0-23.1,0-34.2c-9.2,0-18.1,0-27.1,0C186.9,27.7,186.9,38.7,186.9,50.8z M55,377.6
                              c0-4.7,0-9,0-13.5c-4.5,0-8.8,0-13.3,0c0,4.6,0,9,0,13.5C46.2,377.6,50.4,377.6,55,377.6z M359.4,364.2c-4.7,0-9,0-13.4,0
                              c0,4.6,0,8.9,0,13.3c4.6,0,9,0,13.4,0C359.4,372.9,359.4,368.7,359.4,364.2z"/>
                            <path d="M281.9,273.4c8.7,0,17.5,0,26.2,0c6.8,0,10.2,3.3,10.2,10c0,7.1,0.1,14.2,0,21.3c0,6.4-3.6,9.9-10,9.9
                              c-17.5,0-34.9,0-52.4,0c-6.6,0-10.2-3.5-10.3-10.1c-0.1-7,0-14,0-21c0-6.8,3.4-10.2,10.1-10.2C264.4,273.3,273.1,273.4,281.9,273.4
                              z M306.8,303.4c0-6.4,0-12.4,0-18.5c-16.7,0-33.3,0-49.7,0c0,6.3,0,12.4,0,18.5C273.7,303.4,290.1,303.4,306.8,303.4z"/>
                            <path d="M200.5,151.8c-8.5,0-17,0-25.5,0c-7.5,0-10.8-3.3-10.9-10.7c-0.1-6.7-0.1-13.5,0-20.2c0.1-7.1,3.2-10.5,10.2-10.5
                              c17.4-0.1,34.7-0.1,52.1,0c7.1,0,10.2,3.4,10.3,10.5c0.1,6.9,0.1,13.7,0,20.6c-0.1,7-3.4,10.3-10.4,10.4
                              C217.8,151.9,209.2,151.8,200.5,151.8z M225.4,121.8c-16.7,0-33.1,0-49.7,0c0,6.3,0,12.3,0,18.5c16.7,0,33.1,0,49.7,0
                              C225.4,134.1,225.4,128,225.4,121.8z"/>
                            <path d="M119.2,273.4c8.7,0,17.5,0,26.2,0c6.5,0,10,3.4,10,9.9c0.1,7.1,0.1,14.2,0,21.3c-0.1,6.6-3.6,10.1-10.3,10.1
                              c-17.5,0-34.9,0-52.4,0c-6.4,0-9.9-3.5-10-10c-0.1-7.1,0-14.2,0-21.3c0-6.6,3.4-10,9.9-10C101.5,273.3,110.3,273.4,119.2,273.4z
                              M94.1,303.2c16.9,0,33.4,0,49.9,0c0-6.3,0-12.2,0-18.3c-16.7,0-33.2,0-49.9,0C94.1,291,94.1,297,94.1,303.2z"/>
                          </g>
                        </svg>

                      </div>
                    </div>
                    <div class="notification-info">
                      <div class="text">
                        <strong>{{ notificationProduct[0].user.full_name }}</strong> comment on <strong>{{ notificationProduct[0].product.name }}</strong> product.
                      </div>
                      <div class="date">{{ notificationProduct[0].before_day }}</div>
                    </div>
                  </div>
                </div>
                <!-- Manage notification for product end here -->
                <div class="no-found mb-3" v-if="notificationData.length <= 0 && notificationProductData.length <= 0">
                  <h5 class="text-center">No notification found..</h5>
                </div>
              </div>
              <div class="h-notifications-bottom">
                <!-- <a href="">
                  <icon-base
                    width="14"
                    height="13.07"
                    view-box="0 0 14 13.07"
                    icon-name="volume"
                    ><icon-volume
                  /></icon-base>
                </a>
                <a href="">
                  <icon-base
                    width="14"
                    height="14"
                    view-box="0 0 14 14"
                    icon-name="gear"
                    ><icon-gear
                  /></icon-base>
                </a> -->
              </div>
            </div>
          </div>

          <div class="h-publish">
            <router-link class="btn btn-secondary pusblish-project" :to="{ name: 'projectadd' }"
              >Publish Your Project</router-link
            >
          </div>

          

          <!-- User Menu -->
          <div class="h-user" v-if="isAuthenticated">
            <div class="h-user-userpic" @click="userDropdown = !userDropdown">
         
              <img
                v-if="loggedUser && loggedUser.profile_photo != null"
                :src="loggedUser.profile_photo"
                alt=""
              />
              <img
                v-else
                :src="defaultUserImgUrl"
                alt=""
              />
            </div>

            <!-- User Dropdown -->
            <div class="h-user-dropdown" v-if="userDropdown">
              <div class="username">
                {{ logged_user_full_name }}
              </div>

              <ul class="h-user-nav">
                 <li>
                  <router-link :to="{ name: 'EditProfile' }">
                    Profile</router-link
                  >
                </li>
                <li>
                  <router-link :to="{ name: 'Dashboard' }">
                    Dashboard</router-link
                  >
                </li>
                <li>
                  <router-link :to="{ name: 'Settings-rebranded' }">
                    Setting</router-link
                  >
                </li>

                                <!-- <li>
                                  <router-link :to="{ name: 'INVALID' }">
                                    INVALID</router-link
                                  >
                                </li> -->
                <li>
                  <a @click="doLogout" href="javascript:;">Logout</a>
                </li>
              </ul>
            </div>
          </div>
          <span
            class="mmenu-trigger"
            :class="mmenuExpanded ? 'active' : ''"
            @click="toggleMMenu"
          >
            <span></span>
          </span>
        </div>
      </div>
    </div>

    <modal
      name="login-modal-dialog"
      :width="500"
      height="auto"
      :scrollable="true"
      :adaptive="true"
      transition=""
      class="section-modal section-modal-login"
    >
      <loading
        :active.sync="isLoading"
        :can-cancel="false"
        :is-full-page="fullPage"
        background-color="#000"
        color="#202c54"
      ></loading>

      <!-- Login block -->
      <!-- <section class="section-modal section-modal-login">
        <div class="modal-container">
          <div class="modal-content modal-content-500"> -->
      <div class="modal-close" @click="$modal.hide('login-modal-dialog')">
        <icon-base
          width="24"
          height="24"
          viewBox="0 0 24 23.99"
          icon-name="close-round"
          ><icon-close-round
        /></icon-base>
      </div>

      <!-- Social Login -->
      <div class="social-login-buttons">
        <div id="fb-root"></div>
        <button
          @click.prevent="loginWithFacebook"
          class="btn btn-outline-grey btn-block btn-icon"
        >
          <icon-base
            width="20"
            height="20"
            viewBox="0 0 20 20"
            icon-name="facebook-round"
            ><icon-facebook-round
          /></icon-base>
          <span>Continue with Facebook</span>
        </button>

        <GoogleLogin
          class="btn btn-outline-grey btn-block btn-icon google_login"
          :params="params"
          :onSuccess="loginWithGoogle"
        >
          <icon-base
            width="20"
            height="20"
            viewBox="0 0 20 20"
            icon-name="google"
            ><icon-google
          /></icon-base>
          <span>Continue with Google</span>
        </GoogleLogin>

        <!-- <button class="btn btn-outline-grey btn-block btn-icon">
          <icon-base
            width="26"
            height="20"
            viewBox="0 0 28 21"
            icon-name="twitter"
            ><icon-twitter
          /></icon-base>
          <span>Continue with Twitter</span>
        </button> -->
      </div>

      <div class="login-separator">
        <span>Or</span>
      </div>

      <div class="login-noforms" v-if="isLoginForm == 0">
        <div class="login-links">
          <p>
            <a href="#" @click.prevent="switchSigninRegisterDialog"
              >Signup using Email</a
            >
          </p>
          <p>
            Already a member?
            <button class="btn btn-link p-0" @click="isLoginForm = 1">
              Signin
            </button>
          </p>
        </div>
        <div class="login-text" v-html="loginCMSText"></div>
      </div>

      <div class="login-form" v-if="isLoginForm">
        <form action="">
          <div class="form-group">
            <label for="loginEmailAddress">Email address</label>
            <input
              type="text"
              name="login-email"
              class="form-control"
              autocomplete="off"
              v-model="loginFormData.email"
              id="loginEmailAddress"
              placeholder="Enter email address"
              @keyup.enter="doLogin"
            />
          </div>
          <div class="form-group">
            <label for="loginPassword">Password</label>
            <input
              type="password"
              class="form-control"
              autocomplete="off"
              v-model="loginFormData.password"
              id="loginPassword"
              placeholder="Enter password"
              @keyup.enter="doLogin"
            />
          </div>
          <div class="custom-checkbox-group">
            <label class="custom-checkbox custom-checkbox-sm">
              <input type="checkbox" />
              <span>Keep me signin</span>
            </label>
          </div>

          <button
            class="btn btn-primary btn-lg btn-block"
            @click="doLogin"
            form="login-form"
          >
            Sign In
          </button>
        </form>

        <div class="login-forgotpassword">
          <a class="forgot-password" href="#" @click.prevent="showForgotPassword" style="cursor: pointer">Forgot Password?</a>
        </div>
        <div class="login-signup">
          Don't a Member yet?
          <a href="#" @click.prevent="switchSigninRegisterDialog">Sign Up</a>
        </div>
      </div>
      <!-- </div>
        </div>
      </section> -->
    </modal>
    <!-- login-modal-dialog -->

    <modal
      name="register-modal-dialog"
      :width="500"
      height="auto"
      :scrollable="true"
      :adaptive="true"
      transition=""
      class="section-modal section-modal-register"
    >
      <loading
        :active.sync="isLoading"
        :can-cancel="false"
        :is-full-page="fullPage"
        background-color="#000"
        color="#202c54"
      ></loading>

      <!-- Register block -->

      <div class="modal-close" @click="$modal.hide('register-modal-dialog')">
        <icon-base
          width="24"
          height="24"
          viewBox="0 0 24 23.99"
          icon-name="close-round"
          ><icon-close-round
        /></icon-base>
      </div>

      <div class="register-form">
        <h3 class="h4">Create an account</h3>

        <form action="">
          <div class="form-group">
            <label for="registerEmailAddress">Email address</label>
            <input
              type="text"
              class="form-control"
              autocomplete="off"
              v-model="registerFormData.email"
              id="registerEmailAddress"
              placeholder="Enter email address"
            />
          </div>
          <div class="form-group">
            <label for="registerLogin">Enter username</label>
            <input
              type="text"
              class="form-control"
              autocomplete="off"
              v-model="registerFormData.login"
              id="registerLogin"
              placeholder="Enter username"
            />
          </div>
<!--          <div class="form-group">-->
<!--            <label for="registerFullName">Full name</label>-->
<!--            <input-->
<!--              type="text"-->
<!--              class="form-control"-->
<!--              autocomplete="off"-->
<!--              v-model="registerFormData.full_name"-->
<!--              id="registerFullName"-->
<!--              placeholder="Enter full name"-->
<!--            />-->
<!--          </div>-->
          <div class="form-group">
            <label for="registerPassword">Password</label>
            <input
              type="password"
              class="form-control"
              autocomplete="off"
              v-model="registerFormData.password"
              id="registerPassword"
              placeholder="Create password"
            />
          </div>
          <div class="form-group">
            <label for="registerCPassword">Confirm password</label>
            <input
              type="password"
              class="form-control"
              v-model="registerFormData.cpassword"
              autocomplete="off"
              id="registerCPassword"
              placeholder="Re-enter password"
            />
          </div>

          <div class="custom-checkbox-group">
            <label class="custom-checkbox custom-checkbox-sm">
              <input
                type="checkbox"
                v-model="registerFormData.agree"
                value="1"
              />
              <span
                >I have read and agree to the
                <router-link :to="{ name: 'Terms Conditions' }">terms</router-link>,
                <router-link :to="{ name: 'privacy' }">privacy</router-link>
                and
                <router-link :to="{ name: 'home' }"
                  >other details</router-link
                ></span
              >
            </label>
          </div>

          <button
            class="btn btn-primary btn-lg btn-block mt-3"
            @click="doRegister"
            form="register-form"
          >
            Sign Up
          </button>
        </form>
<!--         <GoogleLogin-->
<!--              class="btn btn-outline-grey btn-block btn-icon"-->
<!--              :params="params"-->
<!--              :onSuccess="doRegisterWithGoogle"-->
<!--            >-->
<!--              <icon-base-->
<!--                width="20"-->
<!--                height="20"-->
<!--                viewBox="0 0 20 20"-->
<!--                icon-name="google"-->
<!--                ><icon-google-->
<!--              /></icon-base>-->
<!--              <span>Continue with Google</span>-->
<!--            </GoogleLogin>-->

        <div class="register-signin">
          Already member?
          <a href="#" @click.prevent="switchRegisterSigninDialog">Sign In</a>
          <!--                <router-link :to="{ name: 'login' }">Sign In</router-link>-->
        </div>
      </div>
    </modal>
    <!-- register-modal-dialog -->

    <!-- Forget Password Modal -->
    <ForgetPwModal />
    <!-- Header / End -->
  </header>
</template>

<script>
import Vue from "vue";
import VueTagsInput from "@johmun/vue-tags-input";
import vSelect from "vue-select";
import IconBase from "./IconBase.vue";
import IconDropdown from "./icons/IconDropdown.vue";
import IconSearch from "./icons/IconSearch.vue";
import IconBell from "./icons/IconBell.vue";
import IconVolume from "./icons/IconVolume.vue";
import IconGear from "./icons/IconGear.vue";
import IconCloseRound from "./icons/IconCloseRound.vue";
import IconFacebookRound from "./icons/IconFacebookRound.vue";
import IconGoogle from "./icons/IconGoogle.vue";
import IconTwitter from "./icons/IconTwitter.vue";
import Loading from "vue-loading-overlay";
import GoogleLogin from "vue-google-login";
import ForgetPwModal from "../header/ForgetPwModal";
import { bus } from "../../app";

Vue.component("v-select", vSelect);
import "vue-select/dist/vue-select.css";

export default {
  name: "Header",
  components: {
    VueTagsInput,
    IconBase,
    IconDropdown,
    Loading,
    IconSearch,
    IconBell,
    GoogleLogin,
    IconVolume,
    IconGear,
    IconCloseRound,
    IconFacebookRound,
    IconGoogle,
    IconTwitter,
    ForgetPwModal,
  },
  computed: {
    isHomepage() {
      return this.$route.path == "/";
    },
    filteredProductItems() {
      if (this.products.length) {
        return this.products.filter((i) => {
          return (
            i.text
              .toLowerCase()
              .indexOf(this.productFilterValue.toLowerCase()) !== -1
          );
        });
      }
      return []
    },
  },
  data() {
    return {
      headerDropdown1: false,
      mmenuExpanded: false,
      notificationsDropdown: false,
      userDropdown: false,
      publicPath: local_image_path,
      isAuthenticated: window.isAuthenticated,
      logged_user_full_name: "",
      logged_user_id: null,
      redirectto: "",
      emailstatus: this.$route.params.emailstatus,
      loggedUser: "",
      loginCMSText: "",
      islogin: 0,
      isfblogin: 0,
      isLoading: false,
      fullPage: true,
      defaultUserImgUrl: "",
      dashboardUrl: "",

      isLoginForm: false,
      loginFormData: {
        email: "",
        password: ""
      },

      isRegisterd: 0,
      loggedUserProfilePhotoImageProps: null,
      registerFormData: {
        login: "",
        full_name: "",
        email: "",
        password: "",
        cpassword: "",
        agree: "",
        proUser: null
      },

      params: {
        client_id: '608538884327-5mk2a79llomn9va7um8tf6g0mr7pnuab.apps.googleusercontent.com'
      },
      renderParams: {
        width: 250,
        height: 50,
        longtitle: true
      },
      redirecturl: "dashboard",
      linkedin_callback: window.linkedin_callback,

      resources: [],
      resourcesProject: [],
      search: "",
      showSearchbox:false,

      notificationData: [],
      notificationProductData: [],
      totalNotiCount: 0,
      searchClass: window.isAuthenticated ? 'login-search-box search-box' : 'search-box',
    };
  },

  methods: {
    async updateComment(slug, id, userId, type){
      if(type == "project"){
        const res = await this.callApi(
          "post",
          window.api_path + "project/updateReviews",
          {
            project_id: id,
            user_id: userId
          }
        );
        if(res.data.status) {
          this.$router.push({ name: 'project', params: { slug: slug } });
        } else {
          this.$toast.error("Something went wrong while viewing comment!");
          return;
        }
      }else{
        const res = await this.callApi(
          "post",
          window.api_path + "product/updateProductReviews",
          {
            product_id: id,
            user_id: userId
          }
        );
        if(res.data.status) {
          this.$router.push({ name: 'Product Page', params: { slug: slug } });
        } else {
          this.$toast.error("Something went wrong while viewing comment!");
          return;
        }
      }
    },
    showSearchResult () {
      if(this.showSearchbox == true)
        this.showSearchbox = false;
      else{
        this.showSearchbox = true;
        this.search = "";
        this.resources = [];
        this.resourcesProject = [];
      }
    },
    async getNotificationData () {
      const res = await Promise.all([
        this.callApi("get", window.api_path + "getNotificationData")
      ])
      if(res[0].data.status){
        this.notificationData = res[0].data.getUserProjectReviews;
        this.notificationProductData = res[0].data.getUserProductReviews;
        this.totalNotiCount = res[0].data.totalNotiCount;
      }else{
        this.notificationData = this.notificationProductData = [];
      }
    },
    async getFilterData () {
      const res = await Promise.all([
        this.callApi("post", window.api_path + "getSearcFilterData", {search_text: this.search})
      ])
      if (this.search) {
        this.resources = res[0].data.products.filter(item =>
          item.name.toLowerCase().includes(this.search.toLowerCase())
        );

        this.resourcesProject = res[0].data.projects.filter(item =>
          item.name.toLowerCase().includes(this.search.toLowerCase())
        );
      } else {
        this.resources = [];
        this.resourcesProject = [];
      }
    },
    async loadLoggedUserProfileData() {
      if (!this.isAuthenticated || !this.logged_user_id) {
        return;
      }

      const result = await this.callApi("get", window.api_path + "profile", {});

      this.loggedUser = result.data.loggedUser;
      this.loggedUserProfilePhotoImageProps =
        result.data.loggedUserProfilePhotoImageProps;
        this.$forceUpdate()
    }, // async loadLoggedUserProfileData() {

    async loadCMSItemByKey(CMSItemKey) {
      const result = await this.callApi(
        "post",
        window.api_path + "getBlockCMSItem",
        {
          key: CMSItemKey
        }
      );

      if (CMSItemKey == "show_login_dialog_block") {
        this.loginCMSText = result.data.cMSItem.text;
      }
    }, // loadCMSItemByKey() {

    toggleMMenu() {
      this.mmenuExpanded = !this.mmenuExpanded;
      this.mmenuExpanded ? this.popupBodyOn() : this.popupBodyOff();
    },
    showForgotPassword () {
      this.$modal.hide('login-modal-dialog')
      this.$modal.show('forget-password-dialog')
    },
    popupBodyOn() {
      document.body.style.top = "-" + window.scrollY + "px";
      document.body.style.position = "fixed";
    },
    popupBodyOff() {
      const scrollY = document.body.style.top;
      document.body.style.position = "";
      document.body.style.top = "";
      window.scrollTo(0, parseInt(scrollY || "0") * -1);
    },

    // LOGIN FORM BLOCK START
    showLoginDialog() {
      this.loadCMSItemByKey("show_login_dialog_block");
      this.loginFormData.email = "";
      this.loginFormData.password = "";
      this.$modal.show("login-modal-dialog");
    },
    hideLoginDialog() {
      this.$modal.hide("login-modal-dialog");
    },

    switchRegisterSigninDialog() {
      this.hideRegisterDialog();
      this.showLoginDialog();
    },
    switchSigninRegisterDialog() {
      this.hideLoginDialog();
      this.showRegisterDialog();
    },

    async doLogin() {
      if (this.loginFormData.email === "") {
        this.$toast.error("Please enter Email");
      } else if (this.loginFormData.password === "") {
        this.$toast.error("Please enter Password");
      } else {
        // do login
        this.isLoading = true;
        const login_details = await this.callApi(
          "post",
          window.api_path + "login",
          {
            email: this.loginFormData.email,
            password: this.loginFormData.password
          }
        );

        if (login_details.status == 200) {
          if (login_details.data.code == 1) {
            this.islogin = 1;
            this.isLoading = false;
            const TIMESTAMP = Date.now();

            if (localStorage.getItem("sgemail") != null) {
              localStorage.removeItem("sgemail");
            }
            localStorage.setItem("sgemail", this.loginFormData.email);
            
            if (localStorage.getItem("sgtoken") != null) {
              localStorage.removeItem("sgtoken");
            }
            localStorage.setItem("sgtoken", login_details.data.token);
            localStorage.setItem("local_storage_set_time", JSON.stringify({
              initial: TIMESTAMP,
              expiresOn: TIMESTAMP + 1000*60*60*12 // 12 hour
            }));

            if (localStorage.getItem("sgname") != null) {
              localStorage.removeItem("sgname");
            }
            localStorage.setItem("sgname", login_details.data.full_name);
            this.logged_user_full_name = login_details.data.full_name;

            if (localStorage.getItem("logged_user_id") != null) {
              localStorage.removeItem("logged_user_id");

            }
            localStorage.setItem(
              "logged_user_id",
              login_details.data.logged_user_id
            );
            this.logged_user_id = login_details.data.logged_user_id;

            if (localStorage.getItem("sgphoto") != null) {
              localStorage.removeItem("sgphoto");
            }
            localStorage.setItem("sgphoto", login_details.data.profile_photo);

            if (localStorage.getItem("sgtype") != null) {
              localStorage.removeItem("sgtype");
            }
            localStorage.setItem("sgtype", 0);

            this.loginFormData.email = "";
            this.loginFormData.password = "";

            window.isAuthenticated = true;
            window.logged_user_id = login_details.data.logged_user_id;
            if (!this.redirecturl) {
              this.redirecturl = "new-dashboard";
            }
            if (typeof this.redirecturl != "undefined") {
              this.$router.push(this.redirecturl);
            } else {
              this.$router.push(this.dashboardUrl);
            }
            this.hideLoginDialog();
          } else {
            this.$toast.error(login_details.data.data);
            this.isLoading = false;
            this.islogin = 2;
          }
        } else {
          this.$toast.error("Details not sent, please try again");
          this.isLoading = false;
          this.islogin = 2;
        }

        if (this.islogin === 0) {
          setTimeout(() => {
            this.isLoading = false;
          }, 10000);
        }
      }
    }, // async doLogin() {

    loginWithFacebook() {
      this.isLoading = true;

      window.FB.login(
        response => {
          console.log("response: ",response);
          if (response.status == "connected") {
            this.loginWithFacebookNext(
              response.authResponse.accessToken,
              response.authResponse.userID
            );
          } else {
            this.isLoading = false;
          }
        },
        { scope: "email" }
      );
    }, // loginWithFacebook() {

    async loginWithFacebookNext(accessToken, userID) {
      const fblogin_details = await this.callApi(
        "post",
        window.api_path + "fblogin",
        {
          token: accessToken,
          user: userID
        }
      );

      if (fblogin_details.status == 200) {
        this.isLoading = false;
        if (fblogin_details.data.code == 1) {
          this.isfblogin = 1;

          if (localStorage.getItem("sgemail") != null) {
            localStorage.removeItem("sgemail");
          }
          localStorage.setItem("sgemail", userID);

          if (localStorage.getItem("sgtoken") != null) {
            localStorage.removeItem("sgtoken");
          }
          localStorage.setItem("sgtoken", fblogin_details.data.token);

          if (localStorage.getItem("sgname") != null) {
            localStorage.removeItem("sgname");
          }
          localStorage.setItem("sgname", fblogin_details.data.name);

          if (localStorage.getItem("sgphoto") != null) {
            localStorage.removeItem("sgphoto");
          }
          localStorage.setItem("sgphoto", fblogin_details.data.photo);

          if (localStorage.getItem("sgtype") != null) {
            localStorage.removeItem("sgtype");
          }
          localStorage.setItem("sgtype", 1);

          window.sgtype = 1;
          window.isAuthenticated = true;
          if (!this.redirecturl) {
            this.redirecturl = "dashboard";
          }
          if (typeof this.redirecturl != "undefined") {
            this.$router.push(this.redirecturl);
          } else {
            this.$router.push({ name: "dashboard" });
          }
        } else {
          this.$toast.error(fblogin_details.data.data);
          this.isfblogin = 2;
        }
      } else {
        this.$toast.error("Login not done, please try again");
        this.isLoading = false;
        this.isfblogin = 2;
      }

      if (this.isfblogin == 0) {
        setTimeout(() => {
          this.isLoading = false;
        }, 10000);
      }
    }, // async loginWithFacebookNext(accessToken, userID) {

    async loginWithGoogle(googleUser) {
      this.isLoading = true;
      var profile = googleUser.getBasicProfile();

      const googlelogin_details = await this.callApi(
        "post",
        window.api_path + "googlelogin",
        {
          name: profile.getName(),
          email: profile.getEmail(),
          user: profile.getId()
        }
      );

      if (googlelogin_details.status == 200) {
        this.isLoading = false;
        if (googlelogin_details.data.code == 1) {
          this.isfblogin = 1;

          if (localStorage.getItem("sgemail") != null) {
            localStorage.removeItem("sgemail");
          }
          localStorage.setItem("sgemail", profile.getEmail());

          if (localStorage.getItem("sgtoken") != null) {
            localStorage.removeItem("sgtoken");
          }
          localStorage.setItem("sgtoken", googlelogin_details.data.token);

          if (localStorage.getItem("sgname") != null) {
            localStorage.removeItem("sgname");
          }
          localStorage.setItem("sgname", googlelogin_details.data.name);

          if (localStorage.getItem("sgphoto") != null) {
            localStorage.removeItem("sgphoto");
          }
          localStorage.setItem("sgphoto", googlelogin_details.data.photo);

          if (localStorage.getItem("sgtype") != null) {
            localStorage.removeItem("sgtype");
          }
          localStorage.setItem("sgtype", 2);

          window.sgtype = 2;
          window.isAuthenticated = true;
          this.isAuthenticated = true;
          window.logged_user_id = googlelogin_details.data.id;
          this.logged_user_id = googlelogin_details.data.id;
          // localStorage.
          localStorage.setItem("logged_user_id", googlelogin_details.data.id);

          if (!this.redirecturl) {
            this.redirecturl = "dashboard";
          }
          if (typeof this.redirecturl != "undefined") {
            this.$router.push(this.redirecturl);
          } else {
            this.$router.push({ name: "dashboard" });
          }
        } else {
          this.$toast.error(googlelogin_details.data.data);
          this.isfblogin = 2;
        }
      } else {
        this.$toast.error("Login not done, please try again");
        this.isLoading = false;
        this.isfblogin = 2;
      }

      if (this.isfblogin == 0) {
        setTimeout(() => {
          this.isLoading = false;
        }, 10000);
      }
    }, // async loginWithGoogle(googleUser) {

    async loginWithIN() {
      var myWidth = 600;
      var myHeight = 600;
      var left = (screen.width - 500) / 2;
      var top = (screen.height - 400) / 4;

      var random_number = Math.floor(Math.random() * 99999999999 + 111111);

      var in_auth_url =
        "https://www.linkedin.com/oauth/v2/authorization?response_type=code&client_id=86pfblgpgdwsgc&redirect_uri=" +
        this.linkedin_callback +
        "&state=" +
        random_number +
        "&scope=r_emailaddress%20r_liteprofile";

      var myWindow = window.open(
        in_auth_url,
        "Test",
        "toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=" +
          myWidth +
          ", height=" +
          myHeight +
          ", top=" +
          top +
          ", left=" +
          left
      );
      myWindow.focus();
    }, // async loginWithIN() {

    // REGISTER FORM BLOCK START
    showRegisterDialog() {
      this.loadCMSItemByKey("show_register_dialog_block");

      this.registerFormData.email = "";
      this.registerFormData.login = "";
      this.registerFormData.full_name = "";
      this.registerFormData.password = "";
      this.registerFormData.cpassword = "";
      this.registerFormData.agree = "";
      this.$modal.show("register-modal-dialog");
    },
    hideRegisterDialog() {
      this.$modal.hide("register-modal-dialog");
    },

    async doRegister() {
      if (this.registerFormData.email == "") {
        this.$toast.error("Please enter Email");
      }else if (!/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/.test(this.registerFormData.email)) {
        this.$toast.error("Please enter the valid email");
      }else if (this.registerFormData.login == "") {
        this.$toast.error("Please enter Username");
      }
      //  else if (this.registerFormData.full_name == "") {
      //   this.$toast.error("Please enter Full Name");
      // }
      else if (this.registerFormData.password == "") {
        this.$toast.error("Please enter Password");
      } else if (this.registerFormData.password.length < 8) {
        this.$toast.error("Please enter minimum 8 character in password");
      } else if (this.registerFormData.cpassword == "") {
        this.$toast.error("Please enter Repeat Password");
      } else if ( this.registerFormData.password != this.registerFormData.cpassword ) {
        this.$toast.error("Both Password must be same");
      } else if (this.registerFormData.agree == "") {
        this.$toast.error("Please Agree to terms of service");
      } else {
        this.isLoading = true;
        const reg_details = await this.callApi(
          "post",
          window.api_path + "registration",
          {
            login: this.registerFormData.login,
            full_name: this.registerFormData.full_name,
            email: this.registerFormData.email,
            type: this.registerFormData.proUser,
            password: this.registerFormData.password,
            cpassword: this.registerFormData.cpassword
          }
        );

        if (reg_details.status == 200) {
          if (reg_details.data.code == 1) {
            this.$toast.success(reg_details.data.data);
            this.isRegisterd = 1;
            this.isLoading = false;
            this.registerFormData.login = "";
            this.registerFormData.full_name = "";
            this.registerFormData.email = "";
            this.registerFormData.password = "";
            this.registerFormData.cpassword = "";
            this.registerFormData.agree = "";
            // this.$router.push({ name: "login" });
            this.hideRegisterDialog();
          } else {
            this.$toast.error(reg_details.data.message || 'Registration error. Please try again');
            this.isLoading = false;
            this.isRegisterd = 2;
          }
        } else {
          this.$toast.error(
            "Registration not done : " + this.getErrorMessage(reg_details)
          );
          this.isLoading = false;
          this.isRegisterd = 2;
        }

        if (this.isRegisterd == 0) {
          setTimeout(() => {
            this.isLoading = false;
          }, 10000);
        }
      }
    }, // async doRegister() {
    // async loginWithGoogle(googleUser) {
    // REGISTER FORM BLOCK END
  }, // methods: {
  // LOGIN FORM BLOCK END

  created() {
    var redirectpath = ["communitydetail"];
    if (redirectpath.indexOf(this.$route.name) >= 0) {
      this.redirectto = this.$route.path;
    }
  },

  mounted() {
    this.getNotificationData();
    this.mmenuExpanded = false;
    this.popupBodyOff();
    this.defaultUserImgUrl = base_url + "images/default-user-avatar-sm.jpg";
    this.dashboardUrl = base_url + "dashboard";
    if (this.$store.state.showLogin) {
      this.showLoginDialog()
      this.$store.state.showLogin = false
    }
    this.logged_user_id = localStorage.getItem("logged_user_id");
    this.logged_user_full_name = localStorage.getItem("sgname");

    if (this.logged_user_id) {
      this.loadLoggedUserProfileData();
    }
    bus.$on("logout_done", () => {
      console.log("INSIDE logout_done::");
      console.log(this.logged_user_id);

      this.isAuthenticated = false;
      this.logged_user_full_name = "";
      this.logged_user_id = null;
      localStorage.removeItem("sgtoken");
      localStorage.removeItem("sgtype");
      localStorage.removeItem("logged_user_id");
      this.islogin = 0;
    }); // bus.$on('logout_done', () => {
  },
};
</script>
