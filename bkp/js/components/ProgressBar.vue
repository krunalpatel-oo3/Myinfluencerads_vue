<template>
    <div>
        <div class="theme-progress">
            <div class="rl-left">
                <span>
                    5 Stars 
                </span>
            </div>
            <div class="rl-right">
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: 95%" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
        
        <div class="theme-progress">
            <div class="rl-left">
                <span>
                    4 Stars 
                </span>
            </div>
            <div class="rl-right">
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
        <div class="theme-progress">
            <div class="rl-left">
                <span>
                    3 Stars 
                </span>
            </div>
            <div class="rl-right">
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
        <div class="theme-progress">
            <div class="rl-left">
                <span>
                    2 Stars 
                </span>
            </div>
            <div class="rl-right">
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
        <div class="theme-progress">
            <div class="rl-left">
                <span>
                    1 Stars 
                </span>
            </div>
            <div class="rl-right">
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: 5%" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped>
    .theme-progress{
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: start;
        -ms-flex-pack: start;
        justify-content: flex-start;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        margin-bottom: 15px;
    }
    .theme-progress:last-child{
        margin-bottom:30px;
    }
    .rl-left span {
        font-weight: 500;
        font-size: 18px;
    }
    .rl-left {
        width: 100px;
    }
    .rl-right {
        width: calc(100% - 100px);
    }
</style>