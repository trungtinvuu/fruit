export const myMixin = {
  data() {
    return {
      myData: 'Hello from mixin'
    };
  },
  created() {
    console.log('Mixin created');
  },
  methods: {
    render(level: number) {
      let result = '';
      if (level>0) {
        for (let i = 0; i < level; i++) {
          result += ' - ';
        }
        return ' '+result+' ';
      } else {
        return '';
      }
    },
  }
};
