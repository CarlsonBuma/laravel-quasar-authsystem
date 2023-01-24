"use strict";

const contacts = [ {
    id: 1,
    name: 'Ruddy Jedrzej',
    email: 'rjedrzej0@discuz.net',
    letter: 'R'
}, {
    id: 2,
    name: 'Mallorie Alessandrini',
    email: 'malessandrini1@marketwatch.com',
    letter: 'M'
}, {
    id: 3,
    name: 'Elisabetta Wicklen',
    email: 'ewicklen2@microsoft.com',
    letter: 'E'
}, {
    id: 4,
    name: 'Seka Fawdrey',
    email: 'sfawdrey3@wired.com',
    letter: 'S'
}]
  
const getGigs = () => {
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
                    status: 'done'
                },{
                    id: 40,
                    label: 'Laravel & SQL',
                    status: 'pending'
                },{
                    id: 2,
                    label: 'Full Stack Webdevelopment',
                    status: 'progress'
                },{
                    id: 20,
                    label: 'Scrum',
                    status: 'progress'
                },
            ]
        }, {
            key: 1,
            entityKey: 1,
            entity: 'EntityName',
            gigKey: 1,
            title: 'GigTitle',
            start: '10.12.2023',
            about: 'sdfasdfw wer wer wers dfsdw er dwsx kdfsfoie sfsdf s,sflkf aidfou asdf  oausdf  asdf kjlas df ajasdlfja lsdjflaj ds lfja',
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

export { 
    contacts,
    getGigs
}