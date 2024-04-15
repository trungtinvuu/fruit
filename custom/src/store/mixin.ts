export const myMixin = {
  data() {
    return {

    };
  },
  created() {

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
