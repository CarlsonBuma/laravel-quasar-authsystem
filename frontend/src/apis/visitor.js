"use strict";

// import axios from 'axios';

const gigsAPI = () => {
    return [
        {
            key: 0,
            entityKey: 0,
            entity: 'EntityName',
            gigKey: 0,
            title: 'GigTitle',
            start: '10.12.2023',
            about: 'Das ist unser Event dwsx kdfsfoie sfsdf s,sflkf aidfou asdf  oausdf  asdf kjlas df ajasdlfja lsdjflaj ds lfja',
            pricerange: [120000, 160000],
            likes: 12,
            duration: 7 + ' weeks',
            progess: {},
            ops: 3,
            skills: [
                {
                    id: 0,
                    label: 'Vue3',
                    available: false
                },{
                    id: 40,
                    label: 'Laravel & SQL',
                    available: true
                },{
                    id: 2,
                    label: 'Full Stack Webdevelopment',
                    available: false
                },{
                    id: 20,
                    label: 'Scrum',
                    available: true
                },
            ]
        }, {
            key: 1,
            entityKey: 1,
            entity: 'EntityName',
            gigKey: 1,
            title: 'GigTitle',
            start: '10.12.2023',
            about: 'Das ist unser Event dwsx kdfsfoie sfsdf s,sflkf aidfou asdf  oausdf  asdf kjlas df ajasdlfja lsdjflaj ds lfja',
            pricerange: [1200, 3000],
            likes: 32,
            duration: 4 + ' weeks',
            progess: {},
            ops: 2,
            skills: [
                {
                    id: 90,
                    label: 'UX Design',
                    available: true
                }
            ]
        }, {
            key: 2,
            entityKey: 2,
            entity: 'EntityName',
            gigKey: 2,
            title: 'GigTitle',
            start: '10.12.2023',
            about: 'Das ist unser Event dwsx kdfsfoie sfsdf s,sflkf aidfou asdf  oausdf  asdf kjlas df ajasdlfja lsdjflaj ds lfja',
            pricerange: [1200000, 167000],
            likes: 11,
            duration: 12 + ' weeks',
            progess: {},
            ops: 12,
            skills: [
                {
                    id: 90,
                    label: 'UX Design',
                    available: true
                },{
                    id: 2,
                    label: 'Full Stack Webdevelopment',
                    available: false
                },{
                    id: 20,
                    label: 'Scrum',
                    available: true
                },
            ]
        }
    ]
}

const teamsAPI = () => {
    return [
        {
            key: 0,                         // Parent: EntityKEY
            available: '06.11.2022',
            line: 'IT',
            name: 'bumaEnitity',
            about: 'Wir sind eine unabhängige Kompanie mit dwsx kdfsfoie sfsdf s,sflkf aidfou asdf  oausdf  asdf kjlas df ajasdlfja lsdjflaj ds lfja',
            skills: [
                {
                    key: 0,
                    label: 'asdf'
                },
                {
                    key: 1,
                    label: 'fffff'
                },
                {
                    key: 2,
                    label: 'ggf'
                },
                {
                    key: 3,
                    label: '44234'
                },{
                    key: 3,
                    label: 'ggdr'
                },{
                    key: 3,
                    label: '234gg'
                },{
                    key: 3,
                    label: '6345'
                },{
                    key: 3,
                    label: 'sfccf'
                }
            ],
            ops: 4,
            pricerange: 10000.20,
            reviews: 34,
        },{
            key: 1,
            available: '01.01.2023',
            line: 'IT',
            name: 'bumaEnitity2',
            about: 'Wir sind eine unabhängige Kompanie mit dwsx kdfsfoie sfsdf s,sflkf aidfou asdf  oausdf  asdf kjlas df ajasdlfja lsdjflaj ds lfja',
            skills: [
                {
                    key: 0,
                    label: 'asdf'
                },
                {
                    key: 1,
                    label: 'fffff'
                },
                {
                    key: 2,
                    label: 'ggf'
                },
                {
                    key: 3,
                    label: '444kkg'
                },{
                    key: 3,
                    label: '64'
                },{
                    key: 3,
                    label: 'vssdf'
                },{
                    key: 3,
                    label: '64kk'
                },{
                    key: 3,
                    label: 'vxcv'
                }
            ],
            ops: 1,
            pricerange: 190.20,
            reviews: 12,
        },{
            key: 2,
            available: '03.11.2022',
            line: 'Service',
            name: 'Company2',
            about: 'Wir sind eine unabhängige Kompanie mit dwsx kdfsfoie sfsdf s,sflkf aidfou asdf  oausdf  asdf kjlas df ajasdlfja lsdjflaj ds lfja',
            skills: [
                {
                    key: 0,
                    label: '6456'
                },
                {
                    key: 1,
                    label: 'fffff'
                },
                {
                    key: 2,
                    label: 'ggf'
                },
                {
                    key: 3,
                    label: '534555345'
                },{
                    key: 3,
                    label: '64kk'
                },{
                    key: 3,
                    label: 'swer'
                },{
                    key: 3,
                    label: 'vxcv'
                },{
                    key: 3,
                    label: 'ljljkljkl'
                }
            ],
            ops: 2,
            pricerange: 500,
            reviews: 134,
        },
    ]
    // return axios.get("/sanctum/csrf-cookie");
}

export { 
    gigsAPI,
    teamsAPI,
};