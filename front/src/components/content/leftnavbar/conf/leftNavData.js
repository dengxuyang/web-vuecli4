export const leftNavData = [{
        index: 'home',
        name: '首页',
        icon: 'el-icon-s-home',
        isRouter: true
    }, {
        index: 'basicdata',
        name: '基础数据',
        icon: 'el-icon-s-order',
        childe: [{
                index: 'play',
                name: '景点管理',
            },
            {
                index: 'stay',
                name: '住宿管理',
            },
            {
                index: 'food',
                name: '美食管理',
            },
            {
                index: 'amuse',
                name: '娱乐管理',
            },
            {
                index: 'pro_owner',
                name: '商店管理',
            },
            {
                index: 'traffic',
                name: '出行管理',
            }
        ]
    }, {
        index: 'travelCommunalFacilities',
        name: '景区设施',
        icon: 'el-icon-office-building',
        childe: [{
                index: 'toilet',
                name: '公共厕所',
            },
             {
                index: 'equipment',
                name: '停车场',
            },

        ]
    }, {
        index: 'travelProduct',
        name: '旅游产品',
        icon: 'el-icon-shopping-bag-1',
        childe: [{
                index: 'commodity',
                name: '特色商品',
            }, {
                index: 'travel_line',
                name: '旅游路线',
            }, {
                index: 'ticket',
                name: '景区门票',
            },

        ]
    }, {
        index: 'tourismInfo',
        name: '资讯信息',
        icon: 'el-icon-chat-line-square',

        childe: [{
                index: 'amt_informationpush',
                name: '信息推送',
            }, {
                index: 'amt_active',
                name: '优惠活动',
            }, {
                index: 'newsinformation',
                name: '新闻资讯',
            }, {
                index: 'amt_picshow',
                name: '美图欣赏',
            }, {
                index: 'amt_videoshow',
                name: '精彩视频',
            }
            , {
                index: 'amt_strategy',
                name: '旅游攻略',
            }

        ]
    }, {
        index: 'travelagent',
        name: '游客互动',
        icon: 'el-icon-user',
        childe: [{
            index: 'sosinfo',
            name: '旅游求助',
        }, {
            index: 'comment',
            name: '游客评论',
        }, {
            index: 'qainfo',
            name: '游客问答',
        }, {
            index: 'consultation',
            name: '游客咨询',
        }, {
            index: 'complaint_case',
            name: '游客投诉',
        }, {
            index: 'amt_telephone',
            name: '常用电话',
        }, {
            index: 'member',
            name: '会员列表',
        }]
    }, {
        index: 'foo',
        icon: 'el-icon-s-data',
        name: '统计分析',
        isRouter: true
    }, {
        index: 'systemcConfig',
        icon: 'el-icon-setting',
        name: '系统配置',
        childe: [{
            index: 'system_config',
            name: '基础配置',
        }, {
            index: 'amt_imageconf',
            name: '图片配置',
        }, {
            index: 'amt_modular',
            name: '模块配置',

        }, {
            index: 'tickettype',
            name: '门票类型',
        }]
    }

]